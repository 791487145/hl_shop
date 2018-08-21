<?php

namespace App\Providers;

use App\Modules\System\Models\AuthMenu;
use App\Modules\System\Models\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
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
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $permissions = AuthMenu::all();
        foreach ($permissions as $permission){
            Gate::define($permission->name,function($user) use($permission){
                return $user->hasPermission($permission);
            });
        }

        Passport::routes();

        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

    }
}
