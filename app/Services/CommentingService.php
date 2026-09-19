<?php

namespace App\Services;

use App\Http\Requests\CommentRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
/**
 * Class CommentingService.
 */
class CommentingService
{
    public function index(Model $model): JsonResponse {
        $comments = $model->comments()->with('user.userProfile.media')->latest()->get();
        return response()->json($comments);
    }

    public function store(Model $model, User $user, string $body): JsonResponse
    {
        $model->comments()->create(['body' => $body, 'user_id' => $user->id]);
        return response()->json(['success' => true]);
    }
}
