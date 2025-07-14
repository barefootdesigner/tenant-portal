<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;


class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $news = News::orderBy('created_at', 'desc')->get();
    return view('news.index', compact('news'));
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    return view('news.create');
}
    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'headline' => 'required|string|max:255',
        'body' => 'required|string',
        'image' => 'nullable|image|max:2048', // 2MB max
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('news-images', 'public');
        $validated['image'] = $path;
    }

    News::create($validated);

    return redirect()->route('news.index')->with('success', 'News item added!');
}


    /**
     * Display the specified resource.
     */
  public function show(\App\Models\News $news)
{
    return view('news.show', compact('news'));
}


public function edit(News $news)
{
    return view('news.edit', compact('news'));
}


public function update(Request $request, News $news)
{
    $validated = $request->validate([
        'headline' => 'required|string|max:255',
        'body' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('news-images', 'public');
        $validated['image'] = $path;
    }

    $news->update($validated);

    return redirect()->route('news.index')->with('success', 'News updated!');
}


public function destroy(News $news)
{
    $news->delete();
    return redirect()->route('news.index')->with('success', 'News deleted!');
}


public function publicIndex()
{
    $news = News::orderBy('created_at', 'desc')->get();
    return view('news.tenant-index', compact('news'));
}



}
