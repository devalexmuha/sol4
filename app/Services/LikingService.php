<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

/**
 * Class LikingService.
 */
class LikingService
{
    public function store(Model $model, User $user): JsonResponse
    {
        $model->likes()->create(['user_id' => $user->id]);

        $count = $model->likes()->count();

        return response()->json([
            'liked' => true,
            'likes_count' => $count,
        ]);
    }

    public function destroy(Model $model, User $user): JsonResponse
    {

        $model->likes()->where('user_id', $user->id)->delete();

        $count = $model->likes()->count();

        return response()->json([
            'liked' => false,
            'likes_count' => $count,
        ]);
    }
}
