<?php

use Illuminate\Support\Facades\Route;

Route::group([
    "namespace" => "App\Http\Controllers\Vendor\SiteGroupPrice\Site",
    "middleware" => ["web"],
    "as" => "site.groups.",
    "prefix" => config("site-group-price.groupUrlName"),
], function () {
    Route::get("/", "GroupController@index")->name("index");
    if (config("site-group-price.onePage", false))
        Route::get("/{group}", "GroupController@show")->name("show");
});