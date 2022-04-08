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
            ->orderBy('recursos.nombre', 'asc')
            ->get([
                'recursos.id as recurso_id',
                'recursos.nombre as nombre_recurso',
                'tipo_recursos.nombre as tipo_recurso',
                'url'
            ]);

        return response()->json(compact('data'), 200);
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
        $validator = Validator::make(
            $request->all(),
            [
                'nombre' => 'required|string|max:60',
                'tipo_recurso_id' => 'required|numeric',
                'ministerio_id' => 'required|numeric',
                'image' => 'required|image'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $path='';
        //Valida si hay imágenes
        if ($request->hasFile('image')) {
            //Almacena el archivo
            $path = $request->file('image')->storeAs('public/images',$request->nombre.time().'.'.$request->image->extension());
            /*Debido a que para acceder a un archivo la ruta es http://localhost:8000/storage/articles/nombredelarchivo.jpeg
            pero en la base de datos queda como public/articles/nombredelarchivo.jpeg, entonces cambio la palabra public por storate en 
            la ruta del archivo que se almacenará en la base de datos

            */
            $path=str_replace('public','storage',$path);
        }
        $recurso = Recurso::create([
            'nombre' => $request->nombre,
            'tipo_recurso_id' => $request->tipo_recurso_id,
            'ministerio_id' => $request->ministerio_id,
            'url'=>$path==""?"":$path,
            'user_created_id' => Auth::user()->id
        ]);

        return response()->json(compact('recurso'), 201);
    }
}
