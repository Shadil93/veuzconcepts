<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'date' => 'required|date',
        'author' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('blogs', 'public');
    }

    Blog::create($validated);

    return response()->json(['message' => 'Blog created successfully']);
}

}
