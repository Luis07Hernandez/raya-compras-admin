<?php

namespace App\Http\Requests;

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
            case 'POST' :
                return [
                    'name' => 'required',
                    'phone' => 'required|min:8|max:10',
                    'sku' => 'required',


                ];

                break;

            case 'PUT' :
                return [

                     'name' => 'required',
                    'phone' => 'required',
                    'sku' => 'required',

                ];
                break;
        }
    }
}
