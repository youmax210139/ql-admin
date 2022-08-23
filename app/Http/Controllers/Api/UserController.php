<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\Users\Resource as UserResource;
use App\Http\Resources\Users\Collection as UserCollection;

class UserController extends Controller
{
    /**
     * Show the profile view.
     *
     * @return json
     */
    public function index()
    {
        return new UserCollection(User::paginate(10));
    }

    /**
     * Show the profile view.
     *
     * @return json
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }
}
