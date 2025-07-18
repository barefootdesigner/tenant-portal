<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\PollVote;

class TenantPollController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $polls = Poll::where('status', 'open')
            ->whereDoesntHave('votes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('tenant.polls.index', compact('polls'));
    }

    public function vote(Request $request, Poll $poll)
    {
        $request->validate([
            'option_id' => 'required|integer',
        ]);

        $user = auth()->user();

        // Check if user has already voted
        if ($poll->votes()->where('user_id', $user->id)->exists()) {
            return redirect()->route('tenant.polls.index')->with('error', 'You have already voted on this poll.');
        }

        // Save the vote
        PollVote::create([
            'poll_id' => $poll->id,
            'user_id' => $user->id,
            'option_id' => $request->option_id,
        ]);

        return redirect()->route('tenant.polls.index')->with('success', 'Thanks for voting!');
    }
}
