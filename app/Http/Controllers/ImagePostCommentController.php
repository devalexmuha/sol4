<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\ImagePost;
use App\Services\CommentingService;
use Illuminate\Http\Request;

class ImagePostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ImagePost $imagePost, CommentingService $commentService)
    {
        if (! request()->expectsJson()) {
            return redirect('/sol/'.$imagePost->id);
        }
        return $commentService->index($imagePost);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImagePost $imagePost, CommentRequest $request, CommentingService $commentService)
    {
        return $commentService->store($imagePost, $request->user(), $request->validated()['body']);
    }
}
