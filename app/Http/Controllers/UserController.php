<?php

namespace App\Http\Controllers;

use Spatie\Url\Url;
use Inertia\Inertia;
use Illuminate\Validation\Rules;
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
        return Inertia::render('Users/Index', [
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

    public function create()
    {
        return Inertia::render('Users/Create', [
            'status' => session('status'),
        ]);
    }

    public function store()
    {
        User::create(
            request()->validate([
                'name' => ['required', "unique:users,name", 'max:100'],
                'email' => ['required', 'unique:users,email', 'max:100'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]),
        );

        return back()->with('status', __('status.store'));
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'status' => session('status'),
            'user' => $user->only('id', 'name', 'email'),
        ]);
    }

    public function update(User $user)
    {
        $user->update(
            request()->validate([
                'name' => ['required', "unique:users,name,{$user->id}", 'max:100'],
                'email' => ['required', 'email', "unique:users,email,{$user->id}", 'max:100'],
            ])
        );

        return back()->with('status', __('status.update'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        $params = Url::fromString(url()->previous())->getAllQueryParameters();
        if (request()->last && isset($params['page'])) {
            $params['page'] = min(1, $params['page'] - 1);
        } else {
            $params['page'] = 1;
        }

        return to_route('users.index', $params)->with('status', __('status.destroy'));
    }
}
