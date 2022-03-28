<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $models = array(
            'Comment',
            // etc...
        );

        foreach ($models as $model) {
            $this->app->bind("App\\Repositories\\Contracts\\{$model}RepositoryContract", "App\\Repositories\\{$model}Repository");
        }
    }
}
