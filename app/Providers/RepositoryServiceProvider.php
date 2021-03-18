<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Http\Interfaces\AuthInterface',
            'App\Http\Repositories\AuthRepository'
        );


        $this->app->bind(
            'App\Http\Interfaces\StaffInterface',
            'App\Http\Repositories\StaffRepository'
        );



        $this->app->bind(
            'App\Http\Interfaces\TeachersInterface',
            'App\Http\Repositories\TeachersRepository'
        );



        $this->app->bind(
            'App\Http\Interfaces\GroupInterface',
            'App\Http\Repositories\GroupRepository'
        );



        $this->app->bind(
            'App\Http\Interfaces\StudentInterface',
            'App\Http\Repositories\StudentRepository'
        );




        $this->app->bind(
            'App\Http\Interfaces\EndUserInterface',
            'App\Http\Repositories\EndUserRepository'
        );


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
