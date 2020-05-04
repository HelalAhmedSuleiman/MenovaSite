<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

interface IAuth{
    public static function register(Request $request, $user_id);
}