<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProvidersRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST' :
                return [
                    'name' => 'required',
                    'phone' => 'required|numeric|digits:10',
                    'email' => 'required|email|unique:users',
                    'image' => 'required',
                    'password' => 'required',
                ];
                break;

            case 'PUT' :
                return [
                    'name' => 'required',
                    'phone' => 'required|numeric|digits:10',
                    'email' => 'required|email',
                    'password' => 'nullable',
                ];
                break;
        }
    }
}
