<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class ImagePostTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Tag $tag)
    {
        $imagePosts = $tag->imagePosts()->with('media', 'comments', 'likes', 'tags',  'user.userProfile.media')->latest()->get();
        return view('image-posts.tags.index', compact('imagePosts', 'tag'));
    }
}
