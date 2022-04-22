<?php

namespace App\Http\Controllers;

use App\Models\Iglesia;
use Illuminate\Http\Request;

class IglesiaController extends Controller
{
    public function index()
    {
        //return Iglesia::all();
        return view('iglesia.index');
    }
}
