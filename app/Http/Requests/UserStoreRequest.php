<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'email' => ['required', 'max:50', 'email', Rule::unique('users')],
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
}
