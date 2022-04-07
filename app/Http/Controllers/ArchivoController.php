<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Js;
use League\Flysystem\File;


class ArchivoController extends Controller
{
    public function index(Request $request)
    {
        
        //$path = $request->archivo->store('articles');
        if($request->hasFile('archivo'))
        {
            
            // $path = $request->image->store('public/articles');
            // $dato=$request->dato;
            // $archivo=$request->arhivo;
            // $archivo=str_replace('data:image/png;base64,','',$archivo);
            // $archivo=str_replace(' ','+',$archivo);
            // $archivoNombre=time().'png';
            //File::put(public_path('/img/',$archivoNombre),base64_decode($archivo));
          // $path = $request->archivo->store('articles');

            return response()->json('Tiene Imagen',200);
        }else{
            return response()->json($request,400);
        }
      
    }
    public function addimage(Request $request)
    {
        // $image = new Image;
        // $image->title = $request->title;
        
            if ($request->hasFile('image')) {
            
            $path = $request->file('image')->store('public/images');
            // $image->url = $path;
           }
        // $image->save();
        return response()->json('path',200);
    }
}
