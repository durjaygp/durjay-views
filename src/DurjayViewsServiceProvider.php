<?php

namespace Durjaygp\DurjayViews;

use Illuminate\Support\ServiceProvider;

class DurjayViewsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'durjay-views');

        // Routes (loaded after config is merged so middleware config is available)
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {

            // Migrations
            $this->publishes([
                __DIR__.'/../database/migrations/create_durjay_views_table.php.stub' =>
                    database_path('migrations/'.date('Y_m_d_His').'_create_durjay_views_table.php'),
            ], 'migrations');

            // Views
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/durjay-views'),
            ], 'views');

            // Config
            $this->publishes([
                __DIR__.'/../config/durjay-views.php' => config_path('durjay-views.php'),
            ], 'config');
        }
    }

    public function register()
    {
        // Merge package config so it works even without publishing
        $this->mergeConfigFrom(__DIR__.'/../config/durjay-views.php', 'durjay-views');
    }
}
