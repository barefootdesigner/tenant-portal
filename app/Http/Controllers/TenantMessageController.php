<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\HiddenMessage;


class TenantMessageController extends Controller
{
public function index()
{
    $user = auth()->user();

    // Get IDs of messages hidden by this user
    $hiddenIds = \App\Models\HiddenMessage::where('user_id', $user->id)->pluck('message_id');

    $messages = \App\Models\Message::where(function ($query) use ($user) {
            $query->where('is_global', true)
                ->orWhere('user_id', $user->id)
                ->orWhere('business_id', $user->business_id);
        })
        ->whereNull('reply_to_id')
        ->whereNotIn('id', $hiddenIds) // <--- Filter hidden messages!
        ->with(['replies.readers'])  // eager load readers of replies
        ->with('readers')           // eager load readers of parent messages
        ->orderBy('created_at', 'desc')
        ->get();

    // This is new: get a list of IDs for messages the user has read
    $readIds = $user->readMessages()->pluck('messages.id')->toArray();

    // Add $readIds to the variables you send to the view
    return view('tenant.messages.index', compact('messages', 'readIds'));
}




public function show($id)
{
    $user = auth()->user();
    $message = Message::with('replies')->findOrFail($id);

    // Mark parent message as read
    $user->readMessages()->syncWithoutDetaching([
        $message->id => ['read_at' => now()],
    ]);

    // Mark all replies as read by tenant
    $replyIds = $message->replies->pluck('id')->toArray();

    if (!empty($replyIds)) {
        $user->readMessages()->syncWithoutDetaching(array_fill_keys($replyIds, ['read_at' => now()]));
    }

    return view('tenant.messages.show', compact('message'));
}


public function create()
{

    return view('tenant.messages.create');
}

public function store(Request $request)
{
    $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:1000',
    ]);

    Message::create([
        'user_id' => auth()->id(),
        'type' => 'Issue',  // fixed category
        'subject' => $request->input('subject'),
        'message' => $request->input('message'),
        'replies_allowed' => true,
    ]);

    return redirect()->route('tenant.messages.index')->with('success', 'Request submitted!');
}










    public function reply(Request $request, Message $message)
{
    $request->validate([
        'message' => 'required|string|max:1000',
    ]);

    Message::create([
        'user_id' => $message->created_by ?? null, // send to whoever created the original
        'reply_to_id' => $message->id,
        'type' => $message->type,
        'message' => $request->input('message'),
        'created_by' => auth()->id(), // will be null if tenant isn’t marked as 'creator'
    ]);

        // ---- Reset admin's "read" marker ----
    $admin = \App\Models\User::role('Admin')->first(); // Spatie role
    if ($admin) {
        \DB::table('message_user_reads')
            ->where('user_id', $admin->id)
            ->where('message_id', $message->id)
            ->delete();
    }
    // -------------------------------------

    return back()->with('success', 'Reply sent!');
}


public function hide(Request $request, $id)
{
    \Log::info('Hide called', [
        'user_id' => $request->user() ? $request->user()->id : null,
        'message_id' => $id,
    ]);

    try {
        \App\Models\HiddenMessage::firstOrCreate([
            'user_id' => $request->user()->id,
            'message_id' => $id,
        ]);
    } catch (\Exception $e) {
        \Log::error('Hide failed: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }

    return response()->json(['success' => true]);
}





}

