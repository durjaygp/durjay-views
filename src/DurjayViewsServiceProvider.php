<?php

namespace Durjaygp\DurjayViews;

use Illuminate\Support\ServiceProvider;

class DurjayViewsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_durjay_views_table.php.stub' => database_path('migrations/'.date('Y_m_d_His').'_create_durjay_views_table.php'),
            ], 'migrations');
        }
    }

    public function register()
    {
        //
    }
}
