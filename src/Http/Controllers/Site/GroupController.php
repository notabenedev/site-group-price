<?php

namespace Notabenedev\SiteGroupPrice\Http\Controllers\Site;

use App\Group;
use App\Price;
use App\Http\Controllers\Controller;
use App\Meta;
use Illuminate\Http\Request;
use Notabenedev\SiteGroupPrice\Facades\GroupActions;
use Notabenedev\SiteGroupPrice\Facades\PriceActions;

class GroupController extends Controller
{
    /**
     *
     * Show onePage price or redirect to first group
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     *
     */
    public function index()
    {
        if (config("site-group-price.onePage", true)) {

            $groups = GroupActions::getTree();
            return view("site-group-price::site.groups.index", [
                "rootGroups" => GroupActions::getRootGroups(),
                "groups" => $groups,
            ]);

        }
        else {

            try {
                $group = Group::query()
                    ->whereNull("parent_id")
                    ->whereNotNull("published_at")
                    ->orderBy("priority")
                    ->firstOrFail();
            }
            catch (\Exception $exception) {
                abort(404);
                $group = null;
            }

            $child = $group->children()->whereNotNull("published_at")->orderBy("priority")->first();
            if ($child) {
                $group = $child;
            }

            return redirect()
                ->route("site.groups.show",
                    ["group" => $group]);

        }

    }

    /**
     * Show group price
     *
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function show(Group $group){

        if (config("site-group-price.onePage", false) || !$group->published_at) {
            return redirect()
                ->route("site.groups.index", [], 301);
        }
        else{

            $groups = GroupActions::getChildrenTree($group);

            return view("site-group-price::site.groups.show", [
                "group" => $group,
                "groups" => $groups,
            ]);
        }
    }

}
