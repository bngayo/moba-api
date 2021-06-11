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
            'profession' => ['nullable', 'max:50'],
            'is_employed' => ['required', 'boolean'],
            'employer' => ['nullable', 'max:50'],
            'business_name' => ['nullable', 'max:50'],
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
            'profession.required' => 'Profession description is required',
            'is_employer.required' => 'Please select your employment status',
        ];
    }
}
