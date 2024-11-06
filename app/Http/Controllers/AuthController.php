<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function getLoginPage()
    {
        return view('public.login');
    }

    public function postLoginRequest()
    {

    }

    public function postLogoutRequest()
    {

    }
}
