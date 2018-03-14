<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeRedirectController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){

        return view('home_redirect');
    }
}
