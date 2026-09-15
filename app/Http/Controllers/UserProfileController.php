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
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $postType = $request->query('post_type', 'images');

        abort_unless(
            in_array($postType, ['images', 'echoes'], true),
            404
        );

        $user = Auth::user()->load('userProfile.media')
            ->loadCount([
                'subscribedTo',
                'subscribers',
                'imagePosts',
                'textPosts',
            ]);

        $posts = (match ($postType) {
            'echoes' => $user->textPosts()
                ->latest(),

            default => $user->imagePosts()
                ->with('media')
                ->latest(),
        })->get();

        return view('profile.show', [
            'user_profile' => $user->userProfile,

            'subscriptions_count' => $user->subscribed_to_count,
            'subscribers_count' => $user->subscribers_count,

            'image_posts_count' => $user->image_posts_count,
            'text_posts_count' => $user->text_posts_count,

            'post_type' => $postType,
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserProfile $userProfile)
    {
        Gate::authorize('modify', $userProfile);
        $userProfile = $userProfile->load('media');

        return view('profile.edit', compact('userProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserProfileRequest $request, UserProfile $userProfile)
    {
        Gate::authorize('modify', $userProfile);
        $validated = $request->validated();
        $userProfile = $userProfile->load('media');
        if ($request->hasFile('logo')) {
            $tmpImagePath = $request->image('logo')->store('tmp', 'local');
            ImageProfileHandler::dispatch($userProfile, $tmpImagePath);
        }
        $userProfile->update([
            'user_name' => $validated['user_name'],
            'user_bio' => $validated['user_bio'],
        ]);

        return redirect("/profile");
    }
}
