<?php

/*
 * WEB
 */

Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend", "can:languages.manage"],
    "namespace" => "Dot\\Languages\\Controllers"
], function ($route) {
    $route->group(["prefix" => "languages"], function ($route) {
        $route->any('/', ["as" => "admin.languages.show", "uses" => "LanguagesController@index"]);
        $route->any('/create', ["as" => "admin.languages.create", "uses" => "LanguagesController@create"]);
        $route->any('/{language_id}/edit', ["as" => "admin.languages.edit", "uses" => "LanguagesController@edit"]);
        $route->any('/delete', ["as" => "admin.languages.delete", "uses" => "LanguagesController@delete"]);
        $route->any('/search', ["as" => "admin.languages.search", "uses" => "LanguagesController@search"]);
    });
});
