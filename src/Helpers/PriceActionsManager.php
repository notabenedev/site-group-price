<?php

namespace Notabenedev\SiteGroupPrice\Helpers;


use App\Group;
use App\Price;

use Illuminate\Support\Facades\Cache;
use Notabenedev\SiteGroupPrice\Events\PriceListChange;
use Notabenedev\SiteGroupPrice\Facades\GroupActions;
use PortedCheese\BaseSettings\Exceptions\PreventActionException;


class PriceActionsManager
{
    /**
     * Изменить Группу прайса.
     *
     * @param Price $price
     * @param int $groupId
     * @throws PreventActionException
     */
    public function changeGroup(Price $price, int $groupId)
    {
        try {
            $group = Group::query()
                ->where("id", $groupId)
                ->firstOrFail();
            $original = $price->group;
        }
        catch (\Exception $exception) {
            throw new PreventActionException("Группа не найдена");
        }
        $price->group_id = $groupId;
        $price->save();

        //при переносле позиции в другую группу меняется набор позиций у обоих групп
        event(new PriceListChange($price->group));
        event(new PriceListChange($original));
        $this::forgetGroupPriceIds($price->group);
        $this::forgetGroupPriceIds($original);

    }
    /**
     * Получить id страниц категории, либо категории и подкатегорий.
     *
     * @param Group $group
     * @param $includeSubs
     * @return mixed
     */
    public function getGroupPageIds(Group $group, $includeSubs = false)
    {
        $key = "price-actions-getGroupPriceIds:{$group->id}";
        $key .= $includeSubs ? "-true" : "-false";
        return Cache::rememberForever($key, function() use ($group, $includeSubs) {
            $query = Price::query()
                ->select("id")
                ->orderBy("priority");
            if ($includeSubs) {
                $query->whereIn("group_id", GroupActions::getGroupChildren($group, true));
            }
            else {
                $query->where("group_id", $group->id);
            }
            $prices = $query->get();
            $pIds = [];
            foreach ($prices as $price) {
                $pIds[] = $price->id;
            }
            return $pIds;
        });
    }

    /**
     * Очистить кэш идентификаторов позиций.
     *
     * @param Group $group
     */
    public function forgetGroupPriceIds(Group $group)
    {
        $key = "price-actions-getGroupPriceIds:{$group->id}";
        Cache::forget("$key-true");
        Cache::forget("$key-false");
        if (! empty($group->parent_id)) {
            $this->forgetGroupPriceIds($group->parent);
        }
    }

    public function getPriceById($id){
        return Price::find($id);
    }


}