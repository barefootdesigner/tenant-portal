<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class TenantMessageController extends Controller
{
    public function index()
    {
        $user = auth()->user();

   $messages = Message::where(function ($query) use ($user) {
        $query->where('is_global', true)
            ->orWhere('user_id', $user->id)
            ->orWhere('business_id', $user->business_id);
    })
    ->whereNull('reply_to_id')
    ->with('replies')
    ->orderBy('created_at', 'desc')
    ->get();


        return view('tenant.messages.index', compact('messages'));
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

    return back()->with('success', 'Reply sent!');
}

}
