<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        return view('parametrizacion.roles.index');
    }
}
