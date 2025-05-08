<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IRLValidationController extends Controller
{
    public function web()
    {
        return view('web/index');
    }
    public function contact()
    {
        return view('web/contact');
    }
    public function MenuSelect($token)
    {
        return view('web/index', compact('token'));
    }
    public function information(){
        return view('web/information');
    }
    public function inf(){
        echo phpinfo();
    }
}
