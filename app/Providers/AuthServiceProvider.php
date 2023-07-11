<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('Administrator', function ($user) {
            return $user->hasRole('Administrator');
        });

        Gate::define('Agency', function ($user) {
            return $user->hasRole('Agency');
        });

        Gate::define('Member', function ($user) {
            return $user->hasRole('Member');
        });

        Gate::define('Partner', function ($user) {
            return $user->hasRole('Partner');
        });

        Gate::define('Super Administrator', function ($user) {
            return $user->hasRole('Super Administrator');
        });

        Gate::define('Supervisor', function ($user) {
            return $user->hasRole('Supervisor');
        });
    }
}
