<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->has('search') && trim(request('search')) === '') {
            return redirect('/users');
        }

        $search = trim((string) request()->query('search', ''));
        $term = '%'.addcslashes($search, '%_\\').'%';

        $users = User::with(['userProfile.media'])
            ->withCount('subscribers')
            ->whereHas('userProfile', function ($query) use ($term) {
                $query->where('user_name', 'like', $term);
            })
            ->orderByDesc('subscribers_count')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $postType = request()->query('post_type', 'images');

        abort_unless(
            in_array($postType, ['images', 'echoes'], true),
            404
        );

        $user->load(['userProfile.media'])
             ->loadCount(['subscribedTo', 'subscribers', 'imagePosts', 'textPosts']);

        $posts = (match ($postType) {
            'echoes' => $user->textPosts()
                ->latest(),

            default => $user->imagePosts()
                ->with('media')
                ->latest(),
        })->get();

        return view('users.show', compact('user', 'posts'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('modify', $user);
        $user->delete();
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }
}
