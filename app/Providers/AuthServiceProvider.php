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

        // Definisikan gate untuk tindakan 'view-dashboard'
        Gate::define('customerService', function ($user) {
            return $user->role_id == '1' || $user->role_id == '4';
        });

        Gate::define('superAdmin', function ($user) {
            return $user->role_id == '4';
        });

        Gate::define('marketingOrAdmin', function ($user) {
            return $user->role_id == '2' || $user->role_id == '4' || $user->role_id == '3';
        });
    }
}
