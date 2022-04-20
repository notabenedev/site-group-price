<?php

namespace Notabenedev\SiteGroupPrice\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Price;
use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Notabenedev\SiteGroupPrice\Facades\GroupActions;
use Notabenedev\SiteGroupPrice\Facades\PriceActions;

class PriceController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Price::class, "price");
    }

    /**
     * Display a listing of the resource.
     *
     *  @param  \Illuminate\Http\Request  $request
     *  @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Group $group = null)
    {
        $query = $request->query;

        $collection = Price::query()
            ->with("group");

        if ($title = $query->get("title", false)) {
            $collection->where("title", "like", "%$title%");
        }

        if (! empty($group)) {
            $groups = GroupActions::getGroupChildren($group, true);
            $collection->whereIn("group_id", $groups);
            $fromRoute = route("admin.groups.prices.index", ["group" => $group]);
        }else {
            $fromRoute = route("admin.prices.index");
        }

        $collection->orderBy("priority", "asc");
        $prices = $collection
            ->paginate()
            ->appends($request->input());

        return view(
            "site-group-price::admin.prices.index",
            compact("group", "fromRoute", "prices", "request")
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function create(Group $group)
    {
        return view(
            "site-group-price::admin.prices.create",
            compact("group")
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group)
    {
        $this->storeValidator($request->all());
        $price = $group->prices()->create($request->all());
        /**
         * @var Price $price
         */
        return redirect()
            ->route("admin.prices.show", ["price" => $price])
            ->with("success", "Добавлено");
    }

    protected function storeValidator($data)
    {
        Validator::make($data, [
            "title" => ["required", "max:150"],
            "slug" => ["nullable", "max:150", "unique:prices,slug"],
            "price" => ["nullable", "max:150"],
            "description" => ["nullable"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "price" => "Цена",
            "description" => "Описание",
        ])->validate();
    }

    /**
     * Display the specified resource.
     *
     * @param  Price $price
     * @return \Illuminate\Http\Response
     */
    public function show(Price $price)
    {
        $group = $price->group;
        $groups = GroupActions::getAllList();
        return view(
            "site-group-price::admin.prices.show",
            compact("price", "group", "groups")
        );
    }

    /**
     * Изменить категорию
     *
     * @param Request $request
     * @param Price $price
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function changeGroup(Request $request, Price $price)
    {
        $this->authorize("update", $price);
        $this->changeGroupValidator($request->all());
        PriceActions::changeGroup($price, $request->get("group_id"));
        return redirect()
            ->route("admin.prices.show", ["price" => $price])
            ->with("success", "Категория изменена");
    }


    protected function changeGroupValidator($data)
    {
        Validator::make($data, [
            "group_id" => "required|exists:groups,id",
        ], [], [
            "group_id" => "Группа",
        ])->validate();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Price  $price
     * @return \Illuminate\Http\Response
     */
    public function edit(Price $price)
    {
        $group = $price->group;

        return view(
            "site-group-price::admin.prices.edit",
            compact("price", "group")
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Price  $price
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Price $price)
    {
        $this->updateValidator($request->all(), $price);
        // Обновление.
        $price->update($request->all());

        return redirect()
            ->route("admin.prices.show", ["price" => $price])
            ->with("success", "Обновлено");
    }

    protected function updateValidator($data, Price $price)
    {
        $id = $price->id;
        Validator::make($data, [
            "title" => ["required", "max:150"],
            "slug" => ["nullable", "max:150", "unique:prices,slug,{$id}"],
            "price" => ["nullable", "max:150"],
            "description" => ["nullable"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "price" => "Цена",
            "description" => "Описание",

        ])->validate();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Price $price
     * @return \Illuminate\Http\Response
     */
    public function destroy(Price $price)
    {
        $group = $price->group;
        $price->delete();
        return redirect()
            ->route("admin.groups.prices.index", ["group" => $group])
            ->with("success", "Удалено");
    }

    /**
     * Tree
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     */

    public function tree(Group $group)
    {
        $this->authorize("update", Price::class);
        $collection = $group->prices()->orderBy("priority")->get();
        $groups = [];
        foreach ($collection as $item) {
            $groups[] = [
                "name" => $item->title,
                "id" => $item->id,
            ];
        }
        return view ("site-group-price::admin.prices.tree", ["groups" => $groups, "group" => $group]);
    }
}
