<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class landingController extends Controller
{
    public function landing(){
        return view('landing.landing');
    }
}
