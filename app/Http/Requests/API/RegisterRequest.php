<?php

namespace App\Http\Requests\API;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'phone' => ['required', 'max:50'],
            'country' => ['required', 'max:50'],
            'class' => ['required', 'max:50'],
            'house' => ['nullable', 'max:50'],
            'prefect' => ['required', 'max:50'],
            'prefect_title' => ['nullable', 'max:50'],
            'password' => ['nullable'],
            'member' => ['required', 'boolean'],
            'photo' => ['nullable', 'image'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = [
            'success' => false,
            'message' => 'Invalid data',
        ];

        if (!empty($errors)) {
            $response['data'] = $errors;
        }

        $response = response()->json($response, 422);

        throw new HttpResponseException($response);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email address is required',
            'phone.required' => 'Phone number is required',
            'password.required' => 'Password is required',
            'confirm_password.required' => 'Confirm your password',
        ];
    }
}
