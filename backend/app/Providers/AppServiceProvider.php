<?php

namespace App\Providers;

use App\Validators\TrueValueValidator;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Passport;

/**
 * Class AppServiceProvider
 * @package App\Providers
 * @author Kostykevich Artyom <kstartfd@gmail.com>
 */
class AppServiceProvider extends ServiceProvider
{
//    protected $policies = [
//        'App\Model' => 'App\Policies\ModelPolicy',
//    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
