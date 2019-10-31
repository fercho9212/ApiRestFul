<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRequest extends FormRequest
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
            'name' =>'required',
            'description'=>'required|min:3|'.Rule::in(['first-zone', 'second-zone']),
            'estado'=>'required|'.Rule::in(['on'])
        ];
    }

    public function messages(){
        return [
            'required'=>'El campo :atribute es requerido',
            'min'=>'El campo debe tener 3',
            'in'=>'The :attribute must be one of the following types: :values'
        ];
    }
}
