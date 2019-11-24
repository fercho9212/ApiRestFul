<?php

namespace App\Http\Requests\Product;

use App\Product;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'description'       =>'required',
            'quantity'          =>'required|numeric|min:1',
            'image'             =>'required|image'
        ];
    }
    public function methodPut()
    {
        return [
            'status'            => Rule::in([Product::PRODUCTO_DISPONIBLE,Product::PRODUCTO_NO_DISPONIBLE]),
            'image'             =>'image'
        ];
    }

    public function methodGet(){
        return [];
    }

    public function methodDelete(){
        return [];
    }

}
