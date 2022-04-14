<?php

namespace Notabenedev\SiteGroupPrice;

use App\Filters\PriceSide;
use App\Filters\PriceSideLg;
use App\Filters\PriceSideMd;
use App\Filters\PriceSideXl;
use App\Group;
use App\Price;
use App\Observers\Vendor\SiteGroupPrice\GroupObserver;
use App\Observers\Vendor\SiteGroupPrice\PriceObserver;

use Illuminate\Support\ServiceProvider;
use Notabenedev\SiteGroupPrice\Console\Commands\GroupPriceMakeCommand;
use Notabenedev\SiteGroupPrice\Events\GroupChangePosition;
use Notabenedev\SiteGroupPrice\Listeners\GroupIdsInfoClearCache;

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

        // Шаблоны изображений
        $this->extendImages();

        // Assets.
        $this->publishes([
            __DIR__ . '/resources/js/components' => resource_path('js/components/vendor/site-group-price'),
            __DIR__ . "/resources/sass" => resource_path("sass/vendor/site-group-price"),
        ], 'public');

        // Events
        $this->addEvents();

        // Наблюдатели.
        $this->addObservers();
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
        $this->app->singleton("price-actions", function () {
            $class = config("site-group-price.priceFacade");
            return new $class;
        });
    }

    /**
     * Подключение Events.
     */

    protected function addEvents()
    {
        // Изменение позиции группы.
        $this->app["events"]->listen(GroupChangePosition::class, GroupIdsInfoClearCache::class);
    }

    /**
     * Добавление наблюдателей.
     */
    protected function addObservers()
    {
        if (class_exists(GroupObserver::class) && class_exists(Group::class)) {
            Group::observe(GroupObserver::class);
        }
        if (class_exists(PriceObserver::class) && class_exists(Price::class)) {
            Price::observe(PriceObserver::class);
        }
    }

    /**
     * Стили для изображений.
     */
    private function extendImages()
    {
        $imagecache = app()->config['imagecache.templates'];

        $imagecache['price-side'] = PriceSide::class;
        $imagecache['price-side-xl'] = PriceSideXl::class;
        $imagecache['price-side-lg'] = PriceSideLg::class;
        $imagecache['price-side-md'] = PriceSideMd::class;

        app()->config['imagecache.templates'] = $imagecache;
    }
}
