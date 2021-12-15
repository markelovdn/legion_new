<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('can-edit-info', function (User $user, Request $request) {
            return
                $user->id == $request->route('id') ||
                $user->role == 1 ||
                $user->id == $request->input('id');
        });

        //не получилось реализовать пришлось просто запрещать действие и выводить сообщение. Не знал
        Gate::define('show-edit-menu', function (User $user) {
            return
                $user->role == 1 ||
                Auth::id() == $user->id;
        });

        Gate::define('can-add-user', function (User $user) {
            return $user->role == 1;
        });
    }
}
