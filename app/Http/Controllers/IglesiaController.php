<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IglesiaController extends Controller
{
    public function index()
    {
        return view('iglesia.index');
    }
}
