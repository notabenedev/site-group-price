<?php

namespace Notabenedev\SiteGroupPrice\Observers;

use App\Price;
use Notabenedev\SiteGroupPrice\Facades\PriceActions;

class PriceObserver
{

    /**
     * После сохранения
     *
     * @param Price $price
     */
    public function created(Price $price){
        PriceActions::forgetGroupPriceIds($price->group);
    }


    /**
     * После обновления.
     *
     * @param Price $price
     */
    public function updated(Price $price)
    {
        $price->clearCache();
        PriceActions::forgetGroupPriceIds($price->group);
    }

    /**
     * После удаления.
     *
     * @param Price $price
     */
    public function deleted(Price $price)
    {
        // Очистить кэш.
        $price->clearCache();
        PriceActions::forgetGroupPriceIds($price->group);
    }

}
