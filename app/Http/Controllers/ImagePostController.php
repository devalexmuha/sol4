<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Jobs\ImagePostHandler;
use App\Models\ImagePost;
use App\Models\Tag;
use Illuminate\Support\Facades\Gate;

class ImagePostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imagePosts = ImagePost::with(['user', 'comments', 'likes', 'tags', 'media'])->latest('updated_at')->get();

        return view('image-posts.index', compact('imagePosts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();

        return view('image-posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $validated = $request->validated();
        $user = $request->user();
        $postData = [
            'image_title' => $validated['image_title'],
            'tmp_image_path' => $request->image('image')->store('tmp', 'local'),
            'tags' => $validated['tags'],
        ];
        ImagePostHandler::dispatch($user, $postData);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(ImagePost $imagePost)
    {
        $imagePost->load(['user.userProfile', 'comments.user.userProfile', 'likes', 'tags', 'media']);

        return view('image-posts.show', compact('imagePost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImagePost $imagePost)
    {
        Gate::authorize('modify', $imagePost);
        $imagePost->load(['tags', 'media']);

        return view('image-posts.edit', compact('imagePost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, ImagePost $imagePost)
    {
        Gate::authorize('modify', $imagePost);
        $validated = $request->validated();
        $imagePost->update([
            'image_title' => $validated['image_title'],
        ]);
        $imagePost->tags()->sync($validated['tags']);

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImagePost $imagePost)
    {
        Gate::authorize('modify', $imagePost);
        $imagePost->delete();

        return redirect('/');
    }
}
