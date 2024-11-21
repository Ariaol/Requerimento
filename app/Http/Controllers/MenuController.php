<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Retorne a view do menu, por exemplo, 'menu.index'
        return view('menu.index');
    }
}
