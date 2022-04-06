<?php

namespace Notabenedev\SiteGroupPrice\Helpers;

use App\Group;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class GroupActionsManager
{

    /**
     * Список всех категорий.
     *
     * @return array
     */
    public function getAllList()
    {
        $groups = [];
        foreach (Group::all()->sortBy("title") as $item) {
            $groups[$item->id] = "$item->title ({$item->slug})";
        }
        return $groups;
    }

    /**
     * Получить дерево категорий.
     *
     * @param bool $forJs
     * @return array
     */
    public function getTree()
    {
        list($tree, $noParent) = $this->makeTreeDataWithNoParent();
        $this->addChildren($tree);
        $this->clearTree($tree, $noParent);
        return $this->sortByPriority($tree);
    }

    /**
     * Сохранить порядок.
     *
     * @param array $data
     * @return bool
     */
    public function saveOrder(array $data)
    {
        try {
            $this->setItemsWeight($data, 0);
        }
        catch (\Exception $exception) {
            return false;
        }
        return true;
    }


    /**
     * Сохранить порядок.
     *
     * @param array $items
     * @param int $parent
     */
    protected function setItemsWeight(array $items, int $parent)
    {
        foreach ($items as $priority => $item) {
            $id = $item["id"];
            if (! empty($item["children"])) {
                $this->setItemsWeight($item["children"], $id);
            }
            $parentId = ! empty($parent) ? $parent : null;
            // Обновление Категории.
            $group = Group::query()
                ->where("id", $id)
                ->first();
            $group->priority = $priority;
            $group->parent_id = $parentId;
            $group->save();
        }
    }

    /**
     * Сортировка результата.
     *
     * @param $tree
     * @return array
     */
    protected function sortByPriority($tree)
    {
        $sorted = array_values(Arr::sort($tree, function ($value) {
            return $value["priority"];
        }));
        foreach ($sorted as &$item) {
            if (! empty($item["children"])) {
                $item["children"] = self::sortByPriority($item["children"]);
            }
        }
        return $sorted;
    }

    /**
     * Очистить дерево от дочерних.
     *
     * @param $tree
     * @param $noParent
     */
    protected function clearTree(&$tree, $noParent)
    {
        foreach ($noParent as $id) {
            $this->removeChildren($tree, $id);
        }
    }

    /**
     * Убрать подкатегории.
     *
     * @param $tree
     * @param $id
     */
    protected function removeChildren(&$tree, $id)
    {
        if (empty($tree[$id])) {
            return;
        }
        $item = $tree[$id];
        foreach ($item["children"] as $key => $child) {
            $this->removeChildren($tree, $key);
            if (! empty($tree[$key])) {
                unset($tree[$key]);
            }
        }
    }

    /**
     * Добавить дочернии элементы.
     *
     * @param $tree
     */
    protected function addChildren(&$tree)
    {
        foreach ($tree as $id => $item) {
            if (empty($item["parent"])) {
                continue;
            }
            $this->addChild($tree, $item, $id);
        }
    }

    /**
     * Добавить дочерний элемент.
     *
     * @param $tree
     * @param $item
     * @param $id
     * @param bool $children
     */
    protected function addChild(&$tree, $item, $id, $children = false)
    {
        // Добавление к дочерним.
        if (! $children) {
            $tree[$item["parent"]]["children"][$id] = $item;
        }
        // Обновление дочерних.
        else {
            $tree[$item["parent"]]["children"][$id]["children"] = $children;
        }

        $parent = $tree[$item["parent"]];
        if (! empty($parent["parent"])) {
            $items = $parent["children"];
            $this->addChild($tree, $parent, $parent["id"], $items);
        }
    }

    /**
     * Получить данные по категориям.
     *
     * @return array
     */
    protected function makeTreeDataWithNoParent()
    {
        $groups = DB::table("groups")
            ->select("id", "title", "slug", "parent_id", "priority")
            ->orderBy("parent_id")
            ->get();

        $tree = [];
        $noParent = [];
        foreach ($groups as $group) {
            $tree[$group->id] = [
                "title" => $group->title,
                'slug' => $group->slug,
                'parent' => $group->parent_id,
                "priority" => $group->priority,
                "id" => $group->id,
                'children' => [],
                "url" => route("admin.groups.show", ['group' => $group->slug]),
                "siteUrl" => route("site.groups.show", ["group" => $group->slug]),
            ];
            if (empty($group->parent_id)) {
                $noParent[] = $group->id;
            }
        }
        return [$tree, $noParent];
    }

    /**
     * Получить id всех подкатегорий.
     *
     * @param Group $group
     * @param bool $includeSelf
     * @return array
     */
    public function getGroupChildren(Group $group, $includeSelf = false)
    {
        $key = "group-actions-getGroupChildren:{$group->id}";
        $children = Cache::rememberForever($key, function () use ($group) {
            $children = [];
            $collection = Group::query()
                ->select("id")
                ->where("parent_id", $group->id)
                ->get();
            foreach ($collection as $child) {
                $children[] = $child->id;
                $groups = $this->getGroupChildren($child);
                if (! empty($groups)) {
                    foreach ($groups as $id) {
                        $children[] = $id;
                    }
                }
            }
            return $children;
        });
        if ($includeSelf) {
            $children[] = $group->id;
        }
        return $children;
    }

    /**
     * Очистить кэш списка id категорий.
     *
     * @param Group $group
     */
    public function forgetGroupChildrenIdsCache(Group $group)
    {
        Cache::forget("group-actions-getGroupChildren:{$group->id}");
        $parent = $group->parent;
        if (! empty($parent)) {
            $this->forgetGroupChildrenIdsCache($parent);
        }
    }

    /**
     * Admin breadcrumbs
     *
     * @param Group $group
     * @param bool $isPagePage
     * @return array
     *
     */
    public function getAdminBreadcrumb(Group $group, $isPricePage = false)
    {
        $breadcrumb = [];
        if (! empty($group->parent)) {
            $breadcrumb = $this->getAdminBreadcrumb($group->parent);
        }
        else {
            $breadcrumb[] = (object) [
                "title" => config("site-group-price.sitePackageName"),
                "url" => route("admin.groups.index"),
                "active" => false,
            ];
        }
        $routeParams = Route::current()->parameters();
        $isPricePage = $isPricePage && ! empty($routeParams["price"]);
        $active = ! empty($routeParams["group"]) &&
            $routeParams["group"]->id == $group->id &&
            ! $isPricePage;
        $breadcrumb[] = (object) [
            "title" => $group->title,
            "url" => route("admin.groups.show", ["group" => $group]),
            "active" => $active,
        ];
        if ($isPricePage) {
            $price = $routeParams["price"];
            $breadcrumb[] = (object) [
                "title" => $price->title,
                "url" => route("admin.prices.show", ["price" => $price]),
                "active" => true,
            ];
        }
        return $breadcrumb;
    }
}