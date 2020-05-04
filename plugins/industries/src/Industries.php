<?php

namespace Dot\Industries;

use Illuminate\Support\Facades\Auth;
use Navigation;
use URL;

class Industries extends \Dot\Platform\Plugin
{

    protected $permissions = [
        "manage"
    ];

    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("industries.manage")) {
                $menu->item('industries', trans("industries::industries.industries"), route("admin.industries.show"))->icon("fa-industry")->order(7);
            }

        });
    }
}
