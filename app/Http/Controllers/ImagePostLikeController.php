<?php

namespace App\Http\Controllers;

use App\Models\ImagePost;
use App\Services\LikingService;
use Illuminate\Http\Request;

class ImagePostLikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ImagePost $imagePost, LikingService $likingService)
    {
        return $likingService->store($imagePost, $request->user() ?? abort(401));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ImagePost $imagePost, LikingService $likingService)
    {
        return $likingService->destroy($imagePost, $request->user() ?? abort(401));
    }}
