<?php

namespace Notabenedev\SiteGroupPrice\Facades;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;

/**
 *
 * Class PageActions
 * @package Notabenedev\SitePages\Facades
 *
 */
class PriceActions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "price-actions";
    }

}