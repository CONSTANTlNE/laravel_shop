<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function loginHtmx(Request $request)
    {
        return view('frontend.auth.login_htmx');
    }

    public function registerHtmx(Request $request)
    {
        return view('frontend.auth.register_htmx');
    }

    public function resetHtmx(Request $request)
    {
        return view('frontend.auth.register_htmx');
    }
}
