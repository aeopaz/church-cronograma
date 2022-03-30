<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MinisterioController extends Controller
{
    public function index()
    {
      return view('ministerio.index');
    }
}
