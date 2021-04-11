<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * @param Request Data de Formulario de Incio de sesión
     * @return acction Registrar un nuevo usuario.
     * @author Manuel Hernández
     * @since 2021-04-10
     * @method GET
     */
    public function store(Request $request){

        $input=$request->all();
        $input['password']=Hash::make($request->password);

        User::create($input);
        return response()->json([
            'res'=> true,
            'message'=>'Usuario creado correctamente'
        ],200);
    }


    public function login(Request $request){

        $login=$request->validate([
            'email'=>'required|string',
            'password'=>'required|string'
        ]);

        if(!Auth::attempt($login)){
            return response(['message'=>'Las credenciales son invalidas.', 'autenticacion'=>false]);
        }

        $accessToken= Auth::user()->createToken('authToken')->accessToken;

        return response(['user'=>Auth::user(), 'autenticacion'=>true, 'access_token'=>$accessToken]);

       /* $user=User::whereEmail($request->email)->first();

        if(!is_null($user) && Hash::check($request->password, $user->password)){
            /*$user->api_token
            $user->save();*/
        /*    return response()->json([
                'res'=> true,
                'token'=> $user->api_token,
                'message'=>'Bienvenido al Sistema'
            ],200); 
        }else{
            return response()->json([
                'res'=> false,
                'message'=>'Cuenta o passwor Incorrectos'
            ],200);
        }*/
    }


    public function logout(){
        $user=Auth::user();
        $user->tokens->each(function($token,$key){
            $token->delete();
        });

        $user->save();

        return response()->json([
            'res'=> true,
            'message'=>'Adios'
        ],200);
    }

   
}
