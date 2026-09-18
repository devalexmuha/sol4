<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserProfile $userProfile)
    {

        $subscribers =  $userProfile->user->subscribers()->withCount('subscribers')->with('userProfile.media')->get();
        $userName = $userProfile->user_name;
        return view('profile.subscribers.index', compact('subscribers', 'userName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, UserProfile $userProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserProfile $userProfile)
    {
        //
    }
}
