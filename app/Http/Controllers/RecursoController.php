<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecursoController extends Controller
{
    public function index()
    {
        $data = Recurso::join('tipo_recursos', 'tipo_recursos.id', 'tipo_recurso_id')
        ->orderBy('recursos.nombre','asc')
            ->get([
                'recursos.id as recurso_id',
                'recursos.nombre as nombre_recurso',
                'tipo_recursos.nombre as tipo_recurso',
                'url'
            ]);

        return response()->json(compact('data'),200);
    }

    public function show($recurso_id)
    {
        $recurso = Recurso::find($recurso_id)->join('tipo_recursos', 'tipo_recursos.id', 'tipo_recurso_id')
            ->get([
                'recursos.id as recurso_id',
                'recursos.nombre as nombre_recurso',
                'tipo_recursos.nombre as tipo_recurso',
                'url'
            ]);

        return response()->json(compact('recurso'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'nombre' => 'required|string|max:60',
                'tipo_recurso_id' => 'required|numeric',
                'ministerio_id' => 'required|numeric'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $recurso = Recurso::create([
            'nombre' => $request->nombre,
            'tipo_recurso_id' => $request->tipo_recurso_id,
            'ministerio_id' => $request->ministerio_id,
            'user_created_id' => Auth::user()->id
        ]);

        return response()->json(compact('recurso'), 201);
    }
}
