<?php

namespace Notabenedev\SiteGroupPrice\Facades;

use Illuminate\Support\Facades\Facade;
use Notabenedev\SiteGroupPrice\Helpers\GroupActionsManager;

/**
 *
 * Class FolderActions
 * @package Notabenedev\SitePages\Facades
 *
 *
 */
class GroupActions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "group-actions";
    }
}