<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class SellerRequest extends FormRequest
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
    public function methodPost(){
        
    }
}
