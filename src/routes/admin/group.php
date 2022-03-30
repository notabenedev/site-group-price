<?php
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Vendor\SiteGroupPrice\Admin\GroupController;

Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {
    Route::resource( "groups" , GroupController::class);

    // Изменить вес у категорий.
    Route::put(config("site-group-price.groupUrlName")."/tree/priority", [GroupController::class,"changeItemsPriority"])
        ->name("groups.item-priority");

    Route::group([
        "prefix" => config("site-group-price.groupUrlName")."/{group}",
        "as" => "groups.",
    ], function () {
        //опубликовать
        Route::put("publish", [GroupController::class,"publish"])
            ->name("publish");

        // Добавить подкатегорию.
        Route::get("create-child", [GroupController::class,"create"])
            ->name("create-child");
        // Сохранить подкатегорию.
        Route::post("store-child", [GroupController::class,"store"])
            ->name("store-child");
        // Meta.
        Route::get("metas", [GroupController::class,"metas"])
            ->name("metas");
    });
}
);
