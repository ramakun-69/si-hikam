<?php

namespace App\Http\Requests\Auth;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    use FailedValidation;
    protected $fill = [
        'username' => 1,
        'password' => 1,
    ];
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $dataValidate = [];
        foreach (array_keys($this->fill) as $key) {
            // dd($key);
            $dataValidate[$key] = ($this->fill[$key] == 1) ? 'required' : 'nullable';
        }
        return $dataValidate;
    }
    public function messages()
    {
        return [
            'username.required' => __("Username cannot be empty"),
            'password.required' => __("Password cannot be empty"),
        ];

    }
}
