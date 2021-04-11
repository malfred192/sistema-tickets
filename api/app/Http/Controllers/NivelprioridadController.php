<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNivelprioridad;
use App\Models\Nip_nivel_prioridad;
use Illuminate\Http\Request;

class NivelprioridadController extends Controller
{
   /**
     * @param None
     * @return Devuelve todos los registros de la tabla Nivel prioridad
     * @author Manuel Hernández
     * @since 2021-04-10
     * @method GET
     */
    public function index(Request $request)
    {
       /* dd($request->all());*/
        return Nip_nivel_prioridad::all();
    }


   /**
     * @param Datos del formulario de Nivel de Prioridad
     * @return true o false
     * @author Manuel Hernández
     * @since 2021-04-10
     * @method POST
     */
    public function store(StoreNivelprioridad $request)
    {
        $input=$request->all();
        Nip_nivel_prioridad::create($input);
        return response()->json([
            'res'=> true,
            'message'=>'Nivel de prioridad creado correctamente.'
        ],200);
    }

   /**
     * @param Id de Nivel de prioridad
     * @return Devuelve el registro del id recibido
     * @author Manuel Hernández
     * @since 2021-04-10
     * @method GET
     */
    public function show($id)
    {
      return Nip_nivel_prioridad::findOrFail($id);
    }

   /**
     * @param Información del formulario y el Id de Nivel de prioridad
     * @return True o false
     * @author Manuel Hernández
     * @since 2021-04-10
     * @method PUT
     */
    public function update(StoreNivelprioridad $request, Nip_nivel_prioridad $nprioridad)
    {
        $input=$request->all();
        $nprioridad->update($input);

        return response()->json([
            'res'=> true,
            'message'=>'Nivel de prioridad modificado correctamente.'
        ],200);
    }

    /**
     * @param Id de Nivel de prioridad
     * @return True o false
     * @author Manuel Hernández
     * @since 2021-04-10
     * @method PUT
     */
    public function destroy($id)
    {
        Nip_nivel_prioridad::Destroy($id);

        return response()->json([
            'res'=> true,
            'message'=>'Registro eliminado correctamente.'
        ],200);

    }
}
