<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserProfile $userProfile)
    {

        $subscriptions =  $userProfile->user->subscribedTo()->withCount('subscribers')->with('userProfile.media')->get();
        $userName = $userProfile->user_name;
        return view('profile.subscriptions.index', compact('subscriptions', 'userName'));
    }
}
