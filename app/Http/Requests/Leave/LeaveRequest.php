<?php

namespace App\Http\Requests\Leave;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
{
    use FailedValidation;
    protected $fill = [
        'nip' => 1,
        'type_of_leave_id' => 1,
        'information' => 0,
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
                case 'date':
                    $dataValidate[$key] .= '|date';
                    break;
            }
        }
        return $dataValidate;
    }
}
