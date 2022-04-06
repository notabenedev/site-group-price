<?php

namespace Notabenedev\SiteGroupPrice\Observers;

use App\Group;
use Notabenedev\SiteGroupPrice\Events\GroupChangePosition;
use PortedCheese\BaseSettings\Exceptions\PreventActionException;
use PortedCheese\BaseSettings\Exceptions\PreventDeleteException;

class GroupObserver
{

    /**
     * Перед сохранением
     *
     * @param Group $group
     */
    public function creating(Group $group){
        if (isset($group->parent_id)) {
            $max = Group::query()
                ->where("parent_id", $group->parent_id)
                ->max("priority");
        }
        else
            $max = Group::query()
                ->whereNull("parent_id")
                ->max("priority");

        $group->priority = $max +1;
        if ($group->isParentPublished())  $group->published_at = now();

    }

    /**
     * После создания.
     *
     * @param Group $group
     */
    public function created(Group $group)
    {
        event(new GroupChangePosition($group));
    }

    /**
     * Перед обновлением.
     *
     * @param Group $group
     * @throws PreventActionException
     */
    public function updating(Group $group)
    {
        $original = $group->getOriginal();
        if (isset($original["parent_id"]) && $original["parent_id"] !== $group->parent_id) {

            if ((! $group->parent->published_at) && $group->published_at) {
               $group->publishCascade();
                //throw new PreventActionException("Невозможно изменить Группу, родитель не опубликован");
            }
            $this->groupChangedParent($group, $original["parent_id"]);
        }

    }

    /**
     * Перед удалением
     *
     * @param Group $group
     * @throws PreventDeleteException
     */
    public function deleting(Group $group){
        if ($group->children->count()){
            throw new PreventDeleteException("Невозможно удалить группу, у нее есть подкатегории");
        }
        if ($group->prices->count()){
            throw new PreventDeleteException("Невозможно удалить группу, у нее есть элементы");
        }
    }

    /**
     * Очистить список id дочерних категорий.
     *
     * @param Group $group
     * @param $parent
     */
    protected function groupChangedParent(Group $group, $parent)
    {
        if (! empty($parent)) {
            $parent = Group::find($parent);
            event(new GroupChangePosition($parent));
        }
        event(new GroupChangePosition($group));
    }

}
