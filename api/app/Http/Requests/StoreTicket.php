<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicket extends FormRequest
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
            'tic_nombre'=>'required',
            'tic_id_nip'=>'required',
            'tic_id_usr'=>'required',
        ];
    }

    public function attributes()
    {
        return [
            'tic_nombre'=>'Nombreeee'
        ];
    }

    public function messages()
    {
        return [
            'tic_id_nip.required'=>'Debe seleccionar un nivel de prioridad',
            'tic_id_usr.required'=>'Debe seleccionar el usuario'
        ];
    }
}
