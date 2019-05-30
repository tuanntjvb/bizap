<?php

namespace App\Providers;

use App\Helpers\AuthAdminHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\SendMailHelper;
use App\Helpers\StringHelper;
use Illuminate\Support\ServiceProvider;

class FacadesProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('date_time_helper', function () {
            return new DateTimeHelper();
        });
        $this->app->singleton('send_mail_helper', function () {
            return new SendMailHelper();
        });
        $this->app->singleton('auth_admin_helper', function () {
            return new AuthAdminHelper();
        });
        $this->app->singleton('string_helper', function () {
            return new StringHelper();
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
