<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('fauth')) {
    function fauth()
    {
        return Auth::guard('frontend');
    }
}