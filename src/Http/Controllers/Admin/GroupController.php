<?php

namespace Notabenedev\SiteGroupPrice\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\Validator;
use Notabenedev\SiteGroupPrice\Facades\GroupActions;

class GroupController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Group::class, "group");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $view = $request->get("view","default");
        $isTree = $view == "tree";
        if ($isTree) {
            $groups = GroupActions::getTree();
        }
        else {
            $collection = Group::query()
                ->whereNull("parent_id")
                ->orderBy("priority","asc");
            $groups = $collection->get();
        }
        return view("site-group-price::admin.groups.index", compact("groups", "isTree"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Group $group = null)
    {
        return view("site-group-price::admin.groups.create", [
            "group" => $group,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group = null)
    {
        $this->storeValidator($request->all());
        if (empty($folder)) {
            $item = Group::create($request->all());
        }
        else {
            $item = $group->children()->create($request->all());
        }

        return redirect()
            ->route("admin.groups.show", ["group" => $item])
            ->with("success", "Добавлено");
    }


    /**
     * Validator
     *
     * @param array $data
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function storeValidator(array $data)
    {
        Validator::make($data, [
            "title" => ["required", "max:250"],
            "slug" => ["nullable", "max:250", "unique:groups,slug"],
            "short" => ["nullable", "max:500"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "short" => "Краткое описание",
        ])->validate();
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


    /**
     * Publish group
     *
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     */

    public function publish(Group $group)
    {
        $this->authorize("update", $group);

        $group->publishCascade();

        return redirect()
            ->back();
    }

    /**
     * Изменить приоритет
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeItemsPriority(Request $request)
    {
        $data = $request->get("items", false);
        if ($data) {
            $result = GroupActions::saveOrder($data);
            if ($result) {
                return response()
                    ->json("Порядок сохранен");
            }
            else {
                return response()
                    ->json("Ошибка, что то пошло не так");
            }
        }
        else {
            return response()
                ->json("Ошибка, недостаточно данных");
        }
    }
}
