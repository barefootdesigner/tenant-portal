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
        $latestNews = News::orderBy('created_at', 'desc')->first();
        $latestOffer = Offer::where('published', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->orderBy('start_date', 'desc')
            ->first();

        return view('dashboard', compact('latestNews', 'latestOffer'));
    }





    
}
