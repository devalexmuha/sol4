<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Tag;
use App\Models\TextPost;
use Illuminate\Support\Facades\Gate;

class TextPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $textPosts = TextPost::with(['user.userProfile.media', 'tags'])
            ->withCount(['likes', 'comments'])
            ->when(auth()->check(),
                function ($q) {
                    $q->withExists([
                        'likes as viewer_has_liked' => function ($q) {
                            $q->where('user_id', auth()->id());

                        },
                    ])->withExists([
                        'comments as viewer_has_commented' => function ($q) {
                            $q->where('user_id', auth()->id());

                        },
                    ]);
                }
            )
            ->latest('updated_at')->get();

        return view('text-posts.index', compact('textPosts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::orderBy('name')->get();

        return view('text-posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $validated = $request->validated();
        $textPost = $request->user()->textPosts()->create([
            'content' => $validated['content'],
        ]);
        $textPost->tags()->attach($validated['tags'] ?? []);

        return redirect('/echoes');
    }

    /**
     * Display the specified resource.
     */
    public function show(TextPost $textPost)
    {
        $textPost->load(['user.userProfile', 'comments.user.userProfile.media', 'likes', 'tags']);

        $authId = auth()->id();
        $textPost->viewer_has_liked     = $authId && $textPost->likes->contains('user_id', $authId);
        $textPost->viewer_has_commented = $authId && $textPost->comments->contains('user_id', $authId);

        return view('text-posts.show', compact('textPost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TextPost $textPost)
    {
        Gate::authorize('modify', $textPost);
        $textPost->load(['user.userProfile', 'tags']);
        $tags = Tag::orderBy('name')->get();

        return view('text-posts.edit', compact('textPost', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, TextPost $textPost)
    {
        Gate::authorize('modify', $textPost);
        $validated = $request->validated();
        $textPost->update([
            'content' => $validated['content'],
        ]);
        $textPost->tags()->sync($validated['tags'] ?? []);

        return redirect('/echoes/'.$textPost->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TextPost $textPost)
    {
        Gate::authorize('modify', $textPost);
        $textPost->delete();

        return redirect('/echoes');
    }
}
