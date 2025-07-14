<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageReplyController extends Controller
{
    public function store(Request $request, Message $message)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Create a reply to the message (as Admin)
        Message::create([
            'user_id'     => $message->created_by ?? null,  // send to whoever created the original
            'reply_to_id' => $message->id,
            'type'        => $message->type,
            'message'     => $request->input('message'),
            'created_by'  => auth()->id(), // ID of the admin user
        ]);

        return back()->with('success', 'Reply sent!');
    }
}
