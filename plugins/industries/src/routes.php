<?php

/*
 * WEB
 */

Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend", "can:industries.manage"],
    "namespace" => "Dot\\Industries\\Controllers"
], function ($route) {
    $route->group(["prefix" => "industries"], function ($route) {
        $route->any('/', ["as" => "admin.industries.show", "uses" => "IndustriesController@index"]);
        $route->any('/create', ["as" => "admin.industries.create", "uses" => "IndustriesController@create"]);
        $route->any('/{industry_id}/edit', ["as" => "admin.industries.edit", "uses" => "IndustriesController@edit"]);
        $route->any('/delete', ["as" => "admin.industries.delete", "uses" => "IndustriesController@delete"]);
        $route->any('/search', ["as" => "admin.industries.search", "uses" => "IndustriesController@search"]);
    });
});
