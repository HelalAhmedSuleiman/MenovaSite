<?php

namespace Dot\Languages;

use Illuminate\Support\Facades\Auth;
use Navigation;
use URL;

class Languages extends \Dot\Platform\Plugin
{

    protected $permissions = [
        "manage"
    ];

    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("languages.manage")) {
                $menu->item('languages', trans("languages::languages.languages"), route("admin.languages.show"))->icon("fa-language")->order(6);
            }

        });
    }
}
