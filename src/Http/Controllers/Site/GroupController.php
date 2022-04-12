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
    public function index(Request $request)
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
                    ->orderBy("priority")
                    ->firstOrFail();
            }
            catch (\Exception $exception) {
                abort(404);
                $group = null;
            }

            $child = $group->children()->orderBy("priority")->first();
            if ($child) {
                $group = $child;
            }

            return redirect()
                ->route("site-group-price::site.groups.show",
                    ["group" => $group]);

        }

    }

}
