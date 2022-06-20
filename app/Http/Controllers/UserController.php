<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    //Registrar usuario
    public function registro(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'celular' => 'required|numeric|max:9999999999',
        //     'password' => 'required|string|min:6|confirmed',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors()->toJson(), 400);
        // }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'celular' => 'required|numeric|max:9999999999',
            'password' => 'required|string|min:5|confirmed',
        ]);
        try {
            
            $user=  User::create();
            $user->name=$request->name;
            $user->email=$request->email;
            $user->celular=$request->celular;
            $user->iglesia_id=1;
            $user->tipo_usuario_id=3;
            $user->estado='I';
            $user->password=Hash::make($request->password);
            $user->save();
            // $user = User::create([
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'celular' => $request->celular,
            //     'iglesia_id' => 1,
            //     'tipo_usuario_id' => 3,
            //     'estado' => 'I',
            //     'password' => Hash::make($request->get('password')),
            // ]);
            $credenciales=['email'=>$request->email,'password'=>$request->password];
            if (Auth::attempt($credenciales)) {
                $request->session()->regenerate();
                return redirect()->intended('home');
            }
            
            // return redirect()->route('login')->with('success','Ya puede ingresar al sistema');
        } catch (\Throwable $th) {
            report($th);
            return back()->with('fail', 'Error en base de datos, favor contactar al administrador del sistema');
        }
        // $token = JWTAuth::fromUser($user);
        // return response()->json(compact('user', 'token'), 201);
    }
    protected function guard()
    {
        return Auth::guard();
    }
    //Actualizar usuario
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'celular' => 'required|numeric|max:9999999999',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->celular = $request->celular;
        $user->save();
        return response()->json(compact('user'), 200);
    }

    //Cambiar contraseña
    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::find(auth()->user()->id);

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = $request->new_password;
            $user->save();
            return response()->json(compact('user'), 200);
        } else {
            return response()->json('Contraseña anterior inválida', 400);
        }
    }
    //Cambiar avatar
    public function change_avatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::find(Auth::user()->id);

        if ($request->hasFile('image')) {
            //$path=$request->file('image')->storeAs('public/images/profile',$user->email.time().'.'.$request->image->extension());
            $path = $request->file('image')->store('public/images/profile');
            $path = str_replace('public', 'storage', $path);
            $user->avatar = $path;
            $user->save();
        }
        return response()->json(compact('user'), 200);
    }
    //Iniciar sesión
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = User::find(Auth::user()->id, ['name', 'email', 'avatar']);
        return response()->json(compact('token', 'user'));
    }

    //Cerrar sesion
    public function logout(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);
            return response()->json([
                'status' => 'ok',
                'message' => 'Successful logout'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unsuccessful logout'
            ], 500);
        }
    }

    //Obtener datos usuario autenticado
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }
}
