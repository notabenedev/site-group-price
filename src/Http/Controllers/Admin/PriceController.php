<?php

namespace Notabenedev\SiteGroupPrice\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Price;
use App\Group;
use Illuminate\Http\Request;
use Notabenedev\SiteGroupPrice\Facades\GroupActions;

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
            $collection->where("group_id", $group->id);
            $fromRoute = route("admin.groups.prices.index", ["group" => $group]);
        }else {
            $fromRoute = route("admin.prices.index");
        }

        if ($published = $request->get("published", "all")) {
            if ($published == "no") {
                $collection->whereNull("published_at");
            }
            elseif ($published == "yes") {
                $collection->whereNotNull("published_at");
            }
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
