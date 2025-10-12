<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of blogs (public access)
     */
    public function index(Request $request)
    {
        $category = $request->get('category');
        $search = $request->get('search');

        $blogs = Blog::published()
            ->recent()
            ->with('author')
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('excerpt', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->paginate(9);

        $categories = Blog::published()
            ->select('category')
            ->groupBy('category')
            ->pluck('category');

        return view('blogs.index', compact('blogs', 'categories', 'category', 'search'));
    }

    /**
     * Display a single blog (public access)
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('is_published', true)
            ->with(['author', 'approvedComments'])
            ->firstOrFail();

        // Increment view count
        $blog->increment('views');

        // Get related blogs (same category)
        $relatedBlogs = Blog::published()
            ->where('category', $blog->category)
            ->where('id', '!=', $blog->id)
            ->recent()
            ->limit(3)
            ->get();

        return view('blogs.show', compact('blog', 'relatedBlogs'));
    }

    /**
     * Store a comment
     */
    public function storeComment(Request $request, $slug)
    {
        $blog = Blog::where('slug', $slug)->where('is_published', true)->firstOrFail();

        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:blog_comments,id',
            'name' => 'required_without:user_id|string|max:100',
            'email' => 'required_without:user_id|email|max:100',
            'website' => 'nullable|url|max:200',
        ]);

        $commentData = [
            'blog_id' => $blog->id,
            'comment' => $validated['comment'],
            'parent_id' => $validated['parent_id'] ?? null,
            'is_approved' => true, // Auto-approve for now
        ];

        if (auth()->check()) {
            $commentData['user_id'] = auth()->id();
        } else {
            $commentData['name'] = $validated['name'];
            $commentData['email'] = $validated['email'];
            $commentData['website'] = $validated['website'] ?? null;
        }

        \App\Models\BlogComment::create($commentData);

        return redirect()->route('blogs.show', $slug)
            ->with('success', 'Comment posted successfully!');
    }
}
