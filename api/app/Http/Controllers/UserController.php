<?php

namespace App\Http\Controllers;

use App\Models\Rol_rol;
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
        $input['usu_estado']=1;
        $input['usu_usu_creacion']=0;
        $input['usu_usu_modificacion']=0;

        User::create($input);
        return response()->json([
            'res'=> true,
            'message'=>'Usuario creado correctamente'
        ],200);
    }


    /**
     * Función que registra un inicio de sesión
     * @param Request Data de Formulario de Incio de sesión
     * @return Generar un inicio de sesión con las credenciales de un usuario.
     * @author Manuel Hernández
     * @since 2021-04-11
     * @method POST
     */
    public function login(Request $request){

        $login=$request->validate([
            'email'=>'required|string',
            'password'=>'required|string'
        ]);

        if(!Auth::attempt($login)){
            return response(['message'=>'Las credenciales son invalidas.', 'autenticacion'=>false]);
        }

        $usuario=Auth::user();

        //Obteniendo los datos del rol del usuario
        $rol=Rol_rol::findOrFail(Auth::user()->usu_id_rol);
        $usuario['rol']=$rol->rol_nombre;
        $usuario['rol_id']=$rol->rol_id;

        $accessToken= Auth::user()->createToken('authToken')->accessToken;

        //Asignamos el token generado al usuario logueado
        $usu=User::findOrFail(Auth::user()->usu_id);

        return response(['user'=>Auth::user(), 'autenticacion'=>true, 'access_token'=>$accessToken]);

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


    public function validarUsuario(){
        $usuario=Auth::user();

        //Obteniendo los datos del rol del usuario
        $rol=Rol_rol::findOrFail(Auth::user()->usu_id_rol);
        $usuario['rol']=$rol->rol_nombre;
        $usuario['rol_id']=$rol->rol_id;

       return $usuario;
    }

    public function validarEmail(Request $data){

       // dd($data->email);

        $band=0;

        $registro = User::select('email')
        ->where('email', $data->email)
       ->get();

        return $registro;


    }

   
}
