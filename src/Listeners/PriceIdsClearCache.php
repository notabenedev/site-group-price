<?php

namespace Notabenedev\SiteGroupPrice\Listeners;

use Notabenedev\SiteGroupPrice\Events\PriceListChange;
use Notabenedev\SiteGroupPrice\Facades\GroupActions;
use Notabenedev\SiteGroupPrice\Facades\PriceActions;

class PriceIdsClearCache
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PriceListChange $event)
    {
        $group = $event->group;
        // Очистить список id категорий.
        PriceActions::forgetGroupPriceIds($group);
    }
}
