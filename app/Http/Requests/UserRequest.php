<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        switch($this->method()){
            case 'GET':
                return $this->methodGet();
            case 'DELETE':
                return $this->methodDelete();
            case 'POST':
                return $this->methodPost();
            case 'PUT':
                return $this->methodPut();
            default :break;
        }

    }
    public function methodPost()
    {
        return [
            'name'              =>'required|string|min:3',
            'email'             =>'required|string|min:3|unique:users',
            'password'          =>'required|string',
        ];
    }
    public function methodPut()
    {
        return [
            'email'             =>'email|unique:users,email'.$this->route('id'),
            'password'          =>'min:6|string',
            'admin'             =>Rule::in([User::USUARIO_ADMINISTRADOR,User::USUARIO_REGULAR])
        ];
    }

    public function methodGet(){
        return [];
    }

    public function methodDelete(){
        return [];
    }

}
