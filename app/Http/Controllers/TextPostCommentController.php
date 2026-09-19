<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\TextPost;
use App\Services\CommentingService;
use Illuminate\Http\Request;

class TextPostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TextPost $textPost, CommentingService $commentService)
    {
        return $commentService->index($textPost);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TextPost $textPost, CommentRequest $request, CommentingService $commentService)
    {
        return $commentService->store($textPost, $request->user(), $request->validated()['body']);
    }
}
