<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Show the profile view.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('User', [
            'status' => session('status'),
            'users' => QueryBuilder::for(User::class)
                ->allowedFilters([
                    'id',
                    'name',
                    'email',
                    'created_at',
                ])
                ->allowedSorts([
                    'id',
                    'name',
                    'email',
                    'created_at',
                ])->paginate(request('perPage', 10))
        ]);
    }

    public function update(Request $request)
    {
        // $request->validate([
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        // $user = auth()->user();
        // $user->password = $request->password;
        // $user->save();
        // event(new PasswordReset($user));

        // return back()->with('status', __(Password::PASSWORD_RESET));
    }
}
