<?php

namespace App\Http\Controllers;

use Illuminate\Cache\RedisTaggedCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Create;
use App\Models\Blog;
class CreateController extends Controller

{
  
    public function index()
    {
        return view('blogs.index');
    }

    public function fetchBlogs()
    {
        $blogs = Blog::all();
        return response()->json($blogs);
    }

//     public function do_register(Request $request)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string',
//             'date' => 'required|date',
//             'author' => 'required|string',
//             'content' => 'required',
//             'image' => 'nullable|image|max:2048',
//         ]);

//         if ($request->hasFile('image')) {
//             $validated['image'] = $request->file('image')->store('blogs', 'public');
//         }

//         $blog = Blog::create($validated);

//         return response()->json($blog);
//     }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'author' => 'required|string',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($blog->image);
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($validated);

        return response()->json($blog);
    }

    public function destroy(Blog $blog)
    {
        Storage::disk('public')->delete($blog->image);
        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully.']);
    }



public function do_register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'date' => 'required|date',
        'author' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $path = $request->file('image') ? $request->file('image')->store('blogs', 'public') : null;

    Blog::create([
        'name' => $validated['name'],
        'date' => $validated['date'],
        'author' => $validated['author'],
        'content' => $validated['content'],
        'image' => $path,
    ]);

    return response()->json(['message' => 'Blog created successfully']);
}


public function logout(){
    Auth::logout();
    return redirect()->route('login');
}
}