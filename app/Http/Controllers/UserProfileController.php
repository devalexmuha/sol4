<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileRequest;
use App\Jobs\ImageProfileHandler;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->has('search') && trim(request('search')) === '') {
            return redirect('/profiles');
        }

        $search = trim((string) request()->query('search', ''));
        $term = '%'.addcslashes($search, '%_\\').'%';

        $users = User::with(['userProfile.media'])
                     ->withCount('subscribers')
                     ->whereHas('userProfile', function ($query) use ($term) {
                         $query->where('user_name', 'like', $term);
                     })
                     ->orderByDesc('subscribers_count')->limit(10)->get();

        return view('profile.index', compact('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(userProfile $userProfile)
    {
        $postType = request()->query('post_type', 'images');

        abort_unless(
            in_array($postType, ['images', 'echoes'], true),
            404
        );

        $userProfile->load(['media', 'user']);
        $userProfile->user->loadCount(['subscribedTo', 'subscribers', 'imagePosts', 'textPosts']);

        $posts = (match ($postType) {
            'echoes' => $userProfile->user->textPosts()
                             ->latest(),

            default => $userProfile->user->imagePosts()
                            ->with('media')
                            ->latest(),
        })->get();

        return view('profile.show', compact('userProfile', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserProfile $userProfile)
    {
        Gate::authorize('modify', $userProfile);
        $userProfile->load(['media', 'user']);

        return view('profile.edit', compact('userProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserProfileRequest $request, UserProfile $userProfile)
    {
        Gate::authorize('modify', $userProfile);
        $validated = $request->validated();
        $userProfile->load(['media', 'user']);
        if ($request->hasFile('logo')) {
            $tmpImagePath = $request->image('logo')->store('tmp', 'local');
            ImageProfileHandler::dispatch($userProfile, $tmpImagePath);
        }
        $userProfile->update([
            'user_name' => $validated['user_name'],
            'user_bio' => $validated['user_bio'],
        ]);

        return redirect('/profiles/' . $userProfile->user_name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserProfile $userProfile)
    {
        Gate::authorize('modify', $userProfile);
        $userProfile->user->delete();
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }
}
