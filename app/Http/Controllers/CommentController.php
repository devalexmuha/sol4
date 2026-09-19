<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        Gate::authorize('modify', $comment);
        $validated = $request->validated();
        $comment->update([
            'body' => $validated['body'],
            'user_id' => $request->user()->id,
        ]);
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('modify', $comment);
        $comment->delete();
        return response()->json(['success' => true]);
    }
}
