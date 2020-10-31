<?php

namespace App\Providers;

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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-admin', function ($user) {
            return $user->role_id === 1;
        });

        Gate::define('edit-scrum', function ($user, $scrum) {
            return $user->is($scrum->user)
                    && $scrum->created_at->isToday();
        });

        Gate::define('edit-profile', function ($user, $profile) {
            return $user->is($profile);
        });
    }
}
