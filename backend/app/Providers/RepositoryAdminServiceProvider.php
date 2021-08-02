<?php

namespace App\Providers;

use App\Entities\User;
use App\Repositories\Admin\User\DoctrineUserAdminRepository;
use App\Repositories\Admin\User\UserAdminRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryAdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserAdminRepository::class, fn($app) => new DoctrineUserAdminRepository(
            $app['em'],
            $app['em']->getClassMetaData(User::class)
        ));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
