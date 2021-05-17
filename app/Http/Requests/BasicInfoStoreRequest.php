<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BasicInfoStoreRequest extends FormRequest
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
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'unique:users,email'],
            'phone' => ['required', 'max:50', 'unique:users,phone'],
            'country' => ['required', 'max:50'],
            'password' => ['required', 'confirmed'],
            'photo' => ['nullable', 'image'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email address',
            'phone.required' => 'Please enter your phone number',
            'country.required' => 'Please select your country of residence',
            'password.required' => 'Please enter your password',
        ];
    }
}
