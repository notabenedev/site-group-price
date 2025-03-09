<?php

namespace Notabenedev\SiteGroupPrice\Listeners;

use App\Price;
use Notabenedev\SiteGroupPrice\Events\PriceListChange;
use Notabenedev\SiteGroupPrice\Facades\GroupActions;
use Notabenedev\SiteGroupPrice\Facades\PriceActions;
use PortedCheese\BaseSettings\Events\PriorityUpdate;

class PricePriorityListener
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
    public function handle(PriorityUpdate $event)
    {
        $table = $event->table;
        $ids = $event->ids;
        if ($table === "prices"){
            $price = Price::query()->whereKey($ids[array_key_first($ids)])->first();
            $group = $price->group;
            event(new PriceListChange($group));
        }
    }
}
