<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TextPostTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Tag $tag)
    {
        $textPosts = $tag->textPosts()
            ->with(['tags', 'user.userProfile.media'])
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
            )->latest()->get();

        return view('text-posts.tags.index', compact('textPosts', 'tag'));
    }
}
