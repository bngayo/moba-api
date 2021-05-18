<?php

namespace App\Http\Requests;

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
            'phone' => ['required', 'max:50', 'unique:users,phone'],
            'country' => ['required', 'max:50'],
            'city' => ['required', 'max:50'],
            'year_completed' => ['required', 'max:50'],
            'house' => ['nullable', 'max:50'],
            'prefect' => ['required', 'max:50'],
            'prefect_title' => ['nullable', 'max:50'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
            'member' => ['required', 'boolean'],
            'photo' => ['nullable', 'image'],
            'membership_plan' => ['required', 'max:50'],
            'billing_cycle' => ['required', 'max:50'],
        ];
    }
}
