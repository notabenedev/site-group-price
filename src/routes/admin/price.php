<?php
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Vendor\SiteGroupPrice\Admin\PriceController;

Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {
   // Route::resource( "prices" , PriceController::class);

    // prices priority
    Route::get(config("site-group-price.groupUrlName")."/{group}/".config("site-group-price.priceUrlName")."/tree", [PriceController::class, "tree"])
        ->name("groups.prices.tree");

    // price to  group
    Route::group([
        "prefix" => config("site-group-price.groupUrlName")."/{group}/".config("site-group-price.priceUrlName"),
        "as" => "groups.prices.",
    ], function (){
        Route::get("/", [PriceController::class, "index"])->name("index");
        Route::get("/create", [PriceController::class, "create"])->name("create");
        Route::post("/", [PriceController::class, "store"])->name("store");
    });


    Route::group([
        "prefix" => config("site-group-price.priceUrlName")."/{price}",
        "as" => "prices.",
    ], function (){
        Route::get("", [PriceController::class, "show"])->name("show");
        Route::get("/edit", [PriceController::class, "edit"])->name("edit");
        Route::put("", [PriceController::class, "update"])->name("update");
        Route::delete("", [PriceController::class, "destroy"])->name("destroy");

        // Изменение категории.
        Route::put("change-group", [PriceController::class,"changeGroup"])
            ->name("change-group");
    });

    //all prices
    Route::get(config("site-group-price.priceUrlName"), [PriceController::class,"index"])
        ->name("prices.index");
}
);
