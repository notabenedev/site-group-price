<?php

namespace Notabenedev\SiteGroupPrice\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Meta;
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
     * @param  \Illuminate\Http\Request  $request
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
     * @param  \App\Group  $group
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
     * @param  Group  $group
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
            "title" => ["required", "max:150"],
            "slug" => ["nullable", "max:150", "unique:groups,slug"],
            "short" => ["nullable", "max:500"],
            "accent" => ["nullable", "max:500"],
            "info" => ["nullable"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "short" => "Краткое описание",
            "accent" => "Акцент",
            "info" => "Информация",
        ])->validate();
    }


    /**
     * Display the specified resource.
     *
     * @param  Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $childrenCount = $group->children->count();
        if ($childrenCount) {
            $children = $group->children()->orderBy("priority")->get();
        }
        else {
            $children = false;
        }
        return view("site-group-price::admin.groups.show", [
            "group" => $group,
            "childrenCount" => $childrenCount,
            "children" => $children
        ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view("site-group-price::admin.groups.edit", compact("group"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Group $group
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Group $group)
    {
        $this->updateValidator($request->all(), $group);
        $group->update($request->all());
        return redirect()
            ->route("admin.groups.show", ["group" => $group])
            ->with("success", "Успешно обновлено");
    }

    /**
     * Update validate
     *
     * @param array $data
     * @param Group $group
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function updateValidator(array $data, Group $group)
    {
        $id = $group->id;
        Validator::make($data, [
            "title" => ["required", "max:150"],
            "slug" => ["nullable", "max:150", "unique:groups,slug,{$id}"],
            "short" => ["nullable", "max:500"],
            "accent" => ["nullable", "max:500"],
            "info" => ["nullable"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "short" => "Краткое описание",
            "accent" => "Акцент",
            "info" => "Информация",
        ])->validate();
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
     * Add metas to group
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function metas(Group $group)
    {
        $this->authorize("viewAny", Meta::class);
        $this->authorize("update", $group);

        return view("site-group-price::admin.groups.metas", [
            'group' => $group,
        ]);
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
