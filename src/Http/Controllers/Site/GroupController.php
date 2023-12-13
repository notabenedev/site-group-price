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

            $siteBreadcrumb = null;

            if (config("site-group-price.siteBreadcrumbs")){
                $siteBreadcrumb = [
                    (object) [
                        'active' => true,
                        'url' => route("site.groups.index"),
                        'title' => config("site-group-price.sitePackageName"),
                    ]
                ];
            }

            $pageMetas = Meta::getByPageKey(config("site-group-price.groupUrlName"));

            $groups = GroupActions::getTree();
            return view("site-group-price::site.groups.index", [
                "rootGroups" => GroupActions::getRootGroups(),
                "groups" => $groups,
                "siteBreadcrumb" => $siteBreadcrumb,
                "pageMetas" => $pageMetas,
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

            $siteBreadcrumb = null;

            if (config("site-group-price.siteBreadcrumbs")){
                $siteBreadcrumb = GroupActions::getSiteBreadcrumb($group);
            }

            $pageMetas = Meta::getByModelKey($group);

            $groups = GroupActions::getChildrenTree($group);

            $template = (! config("site-group-price.usePriceImage", false)) ?
                "site-group-price::site.groups.includes.item-price":
                "site-group-price::site.groups.includes.item-price-teaser";


            return view("site-group-price::site.groups.show", [
                "group" => $group,
                "groups" => $groups,
                "template" => $template,
                "siteBreadcrumb" => $siteBreadcrumb,
                "pageMetas" => $pageMetas,
            ]);
        }
    }

}
