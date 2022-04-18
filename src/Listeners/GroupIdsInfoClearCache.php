<?php

namespace Notabenedev\SiteGroupPrice\Listeners;

use Notabenedev\SiteGroupPrice\Events\GroupChangePosition;
use Notabenedev\SiteGroupPrice\Facades\GroupActions;

class GroupIdsInfoClearCache
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
    public function handle(GroupChangePosition $event)
    {
        $group = $event->group;
        // Очистить список id категорий.
        GroupActions::forgetGroupChildrenIdsCache($group);
        GroupActions::forgetGroupParentsCache($group);
    }
}
