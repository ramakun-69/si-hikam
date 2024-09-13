<?php

namespace App\Http\Requests\User;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    use FailedValidation;
    protected $fill = [
        'id' => 0,
        'name' => 1,
        'nip' => 1,
        'username' => 1,
        'address' => 1,
        'phone' => 1,
        'photo' => 0
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
            $dataValidate[$key] = ($this->fill[$key] == 1) ? 'required' : 'nullable';
            switch ($key) {
                case 'photo':
                    $dataValidate[$key] .= '|image|max:10256';
                    break;
                case 'nip':
                    $dataValidate[$key] .= '|unique:employees,nip,'.$this->nip.',nip';
                    break;
            }
        }
        return $dataValidate;
    }
}
