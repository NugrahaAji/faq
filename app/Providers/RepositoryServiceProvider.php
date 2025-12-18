<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Contracts\TopicRepositoryInterface::class,
            \App\Repositories\TopicRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\SubTopicRepositoryInterface::class,
            \App\Repositories\SubTopicRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\FaqRepositoryInterface::class,
            \App\Repositories\FaqRepository::class
        );
    }

    public function boot()
    {
        //
    }
}
