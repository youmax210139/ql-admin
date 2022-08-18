<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\PasswordReset;

class ProfileController extends Controller
{
    /**
     * Show the profile view.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Profile', [
            'status' => session('status'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = auth()->user();
        $user->password = $request->password;
        $user->save();
        event(new PasswordReset($user));

        return back()->with('status', __(Password::PASSWORD_RESET));
    }
}
