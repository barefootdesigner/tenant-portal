<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $query = Business::query();

        // If a search term is present, filter businesses
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $businesses = $query->orderBy('name')->get();

        return view('business.directory', compact('businesses'));
    }

    public function show(Business $business)
    {
        $business->load('users');
        return view('business.show', compact('business'));
    }
}
