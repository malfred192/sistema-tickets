<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNivelprioridad extends FormRequest
{

    protected $primaryKey = 'nip_id';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      //  dd($this->route('nprioridad')->nip_id);
       //|unique:nip_nivel_prioridads,nip_nombre,'.$this->route('nprioridad')->nip_id 
        
        return [
            'nip_nombre'=>'required'
        ];
    }

    public function attributes()
    {
        return [
            'nip_nombre'=>'Nombre de Prioridad'
        ];
    }

    public function messages()
    {
        return [
            'nip_nombre.required'=>'Nombre de la Prioridad es requerido.',
            'nip_nombre.unique'=>'El nivel de prioridad ya existe.',
        ];
    }
}
