<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'email'    => $validated['email'],
            'password' => $validated['password'],
        ]);

        $user->userProfile()->create([
            'user_name' => Str::before($validated['email'], '@') . '_' . Str::random(4),
        ]);

        Auth::login($user);
        return redirect('/');

    }
}
