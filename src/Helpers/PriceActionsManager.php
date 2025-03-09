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
        //$this::forgetGroupPriceIds($price->group);
        //$this::forgetGroupPriceIds($original);

    }
    /**
     * Получить id позиций группы, либо  группы и подгруппы.
     *
     * @param int $groupId
     * @param $includeSubs
     * @return mixed
     */
    public function getGroupPriceIds($groupId, $includeSubs = false)
    {
        $group = Group::query()->where("id","=",$groupId)->first();
        $key = "price-actions-getGroupPrice:{$group->id}";
        $key .= $includeSubs ? "-true" : "-false";
        return Cache::rememberForever($key, function() use ($group, $includeSubs) {
            $query = Price::query()
                ->select("title", "id", "slug", "price", "description")
                ->orderBy("priority");
            if ($includeSubs) {
                $query->whereIn("group_id", GroupActions::getGroupChildren($group, true));
            }
            else {
                $query->where("group_id", $group->id);
            }
            $prices = $query->get();

            $items = [];
            foreach ($prices as $item) {
                $items[$item->id] = $item;
            }

            return $items;
        });
    }

    /**
     * Очистить кэш идентификаторов позиций.
     *
     * @param Group $group
     */
    public function forgetGroupPriceIds(Group $group)
    {
        $key = "price-actions-getGroupPrice:{$group->id}";
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