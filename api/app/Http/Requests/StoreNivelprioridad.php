<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNivelprioridad extends FormRequest
{
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
        return [
            'nip_nombre'=>'required',
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
        ];
    }
}
