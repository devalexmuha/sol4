<?php

namespace App\Http\Controllers;

use App\Models\TextPost;
use App\Services\LikingService;
use Illuminate\Http\Request;

class TextPostLikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TextPost $textPost, LikingService $likingService)
    {
        return $likingService->store($textPost, $request->user() ?? abort(401));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, TextPost $textPost, LikingService $likingService)
    {
        return $likingService->destroy($textPost, $request->user() ?? abort(401));
    }
}
