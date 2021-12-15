<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function updateAdmin(User $user)
    {
        return $user->role == 1;
    }

    public function updateUser(User $user, Request $request)
    {
        return $user->id === $request->route('id');
    }


    public function create(User $user)
    {
        return $user->role == 1;
    }
}
