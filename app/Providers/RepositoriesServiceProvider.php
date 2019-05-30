<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

##AUTO_INSERT_USE##
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\UserRepository;
use App\Models\User;

class RepositoriesServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        ##AUTO_INSERT_BIND##
        $this->app->bind(IUserRepository::class, function () {
            return new UserRepository(new User());
        });
    }

    public function provides()
    {
        return [
            ##AUTO_INSERT_NAME##
            IUserRepository::class,
        ];
    }
}
