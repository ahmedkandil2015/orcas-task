<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\User\Eloquent\EloquentUserRepository;
use App\Repositories\User\UserRepository;
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

      
        $this->app->bind(UserRepository::class,function(){
            return  new EloquentUserRepository(new User());
        });


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
