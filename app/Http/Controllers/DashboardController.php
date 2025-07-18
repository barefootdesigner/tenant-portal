<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Offer;
use App\Services\MetaWeatherService;


class DashboardController extends Controller
{
  public function index()
{
    $user = auth()->user();
    $readIds = $user->readMessages()->pluck('messages.id')->toArray();

    // Fetch messages for the tenant
    // Get IDs of messages hidden by the user
$hiddenIds = $user->hiddenMessages()->pluck('messages.id')->toArray();
// (If your relationship uses a different name or table, let me know!)

    $messages = \App\Models\Message::where(function ($query) use ($user) {
        $query->where('is_global', true)
            ->orWhere('user_id', $user->id)
            ->orWhere('business_id', $user->business_id);
    })
    ->whereNull('reply_to_id')
    ->orderBy('created_at', 'desc')
    ->with(['replies.readers'])
    ->get();

    // Only "new" messages for dashboard
$newMessages = $messages->filter(function($message) use ($readIds, $hiddenIds, $user) {
    $tenantId = $user->id;
    $unreadReplyExists = $message->replies->where('created_by', '!=', $tenantId)
        ->filter(function($reply) use ($tenantId) {
            return !$reply->readers->contains($tenantId);
        })->isNotEmpty();

    return (
        (!in_array($message->id, $readIds) || $unreadReplyExists)
        && !in_array($message->id, $hiddenIds)
    );
});


    $latestNews = News::orderBy('created_at', 'desc')->first();
    $latestOffer = Offer::where('published', true)
        ->whereDate('start_date', '<=', now())
        ->whereDate('end_date', '>=', now())
        ->orderBy('start_date', 'desc')
        ->first();

    // Pass newMessages along with your other dashboard stuff
    return view('dashboard', compact('latestNews', 'latestOffer', 'newMessages'));
}





    
}
