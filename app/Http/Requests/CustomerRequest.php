<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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

                    'contact_name' => 'required',
                    'last_name' => 'required|max:24',
                    'email' => 'required',
                    'phone' => 'required|max:15',
                    'rfc' => 'required|max:15',
                    'commercial_name' => 'required|max:15',
                    'password' => 'nullable|max:20|min:5',

                    'confirm_password' =>'same:password',




                ];

                break;

            case 'PUT' :
                return [
                    'contact_name' => 'required',
                    'last_name' => 'max:24',
                    'email' => 'required',
                    'rfc' => 'max:24',
                    'commercial_name' => 'max:24',
                    'phone' => 'required|max:15',
                    'seller_id' => 'required',
                    'password' => 'nullable|max:20|min:5',

                    'confirm_password' =>'same:password',



                ];
                break;
        }
    }
}
