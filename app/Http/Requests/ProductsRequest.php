<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
                    'description'=> 'required|max:255',
                    // 'price'=> 'required|max:255',
                    // 'key'=> 'required|max:15',
                    'image'=> 'required|max:255',
                    'category_id'=> 'required|max:255',
                   // 'unit_id'=> 'required|max:255',
                    'status'=> 'nullable|max:3',
                    'outstanding'=> 'nullable|max:3',
                    // 'product_key' => 'required|max:15',
               

                ];

                break;

            case 'PUT' :
                return [
                    'name' => 'required',
                    'description'=> 'required',
                    // 'price'=> 'required',
                    // 'key'=> 'required|max:15',
                    'image'=> 'nullable',
                    'category_id'=> 'required',
                   // 'unit_id'=> 'nullable',
                    'status'=> 'nullable',
                    'outstanding'=> 'nullable',
                    // 'product_key' => 'required|max:15',
                ];
                break;
        }
    }
}
