<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstadoTicket extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'est_nombre'=>'required',
        ];
    }

    public function attributes()
    {
        return [
            'est_nombre'=>'Nombre de Estado'
        ];
    }

    public function messages()
    {
        return [
            'est_nombre.required'=>'Nombre del Estado es requerido.',
        ];
    }
}
