<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
  public function index(Request $request)
{
    $category = $request->query('category');

    $offers = Offer::where('published', true)
        ->whereDate('start_date', '<=', now())
        ->whereDate('end_date', '>=', now());

    if ($category) {
        $offers = $offers->where('category', $category);
    }

    $offers = $offers->orderBy('start_date', 'desc')->get();

    // Get all distinct categories for the dropdown
    $categories = Offer::select('category')
        ->whereNotNull('category')
        ->distinct()
        ->pluck('category');

    return view('offers.index', compact('offers', 'category', 'categories'));
}


public function show(\App\Models\Offer $offer)
{
    return view('offers.show', compact('offer'));
}

}
