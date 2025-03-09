<?php

namespace Notabenedev\SiteGroupPrice\Observers;

use App\Price;
use Notabenedev\SiteGroupPrice\Events\GroupChangePosition;
use Notabenedev\SiteGroupPrice\Events\PriceListChange;
use Notabenedev\SiteGroupPrice\Facades\PriceActions;

class PriceObserver
{

    /**
     * После сохранения
     *
     * @param Price $price
     */
    public function created(Price $price){
        event(new PriceListChange($price->group));
    }


    /**
     * После обновления.
     *
     * @param Price $price
     */
    public function updated(Price $price)
    {
        event(new PriceListChange($price->group));
    }

    /**
     * После удаления.
     *
     * @param Price $price
     */
    public function deleted(Price $price)
    {
        event(new PriceListChange($price->group));
    }

}
