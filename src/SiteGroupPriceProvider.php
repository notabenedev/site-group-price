<?php

namespace Notabenedev\SiteGroupPrice;

use App\Group;
use App\Price;
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

        $this->initFacades();
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

        //Подключаем роуты
        if (config("site-group-price.groupAdminRoutes")) {
            $this->loadRoutesFrom(__DIR__."/routes/admin/group.php");
            $this->loadRoutesFrom(__DIR__."/routes/site/group.php");
            $this->loadRoutesFrom(__DIR__."/routes/admin/price.php");
        }

        // Подключение шаблонов.
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'site-group-price');

        // Подключение метатегов.
        $seo = app()->config["seo-integration.models"];
        $seo["groups"] = Group::class;
        $seo["prices"] = Price::class;
        app()->config["seo-integration.models"] = $seo;

        // Assets.
        $this->publishes([
            __DIR__ . '/resources/js/components' => resource_path('js/components/vendor/site-group-price'),
        ], 'public');


    }

    /**
     * Подключение Facade.
     */
    protected function initFacades()
    {
        $this->app->singleton("group-actions", function () {
            $class = config("site-group-price.groupFacade");
            return new $class;
        });
    }
}
