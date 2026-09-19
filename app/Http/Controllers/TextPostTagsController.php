<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TextPostTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Tag $tag)
    {
        $textPosts = $tag->textPosts()->with('comments', 'likes', 'tags',  'user.userProfile.media')->latest()->get();
        return view('text-posts.tags.index', compact('textPosts', 'tag'));
    }
}
