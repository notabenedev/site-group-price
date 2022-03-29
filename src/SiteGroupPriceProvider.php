<?php

namespace Notabenedev\SiteGroupPrice;

use Illuminate\Support\ServiceProvider;
use Notabenedev\SiteGroupPrice\Console\Commands\GroupPriceMakeCommand;

class SiteGroupPriceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/site-group-price.php','site-group-price'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //Публикация конфигурации
        $this->publishes([__DIR__.'/config/site-group-price.php' => config_path('site-group-price.php'),
            ], 'config');

        //Подключение миграций
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        //Console
        if ($this->app->runningInConsole()){
            $this->commands([
                GroupPriceMakeCommand::class,
            ]);
        }
    }
}
