<?php

namespace Rajagonda\GondaYoutube;

use Illuminate\Support\ServiceProvider;

class GondaYoutubeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath(__DIR__ . '/config/gondayoutube.php');

        $this->publishes([$source => config_path('gondayoutube.php')]);

        $this->mergeConfigFrom($source, 'gondayoutube');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GondaYoutube::class, function () {
            return new GondaYoutube(config('youtube.key'));
        });

        $this->app->alias(GondaYoutube::class, 'gondayoutube');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [GondaYoutube::class];
    }
}
