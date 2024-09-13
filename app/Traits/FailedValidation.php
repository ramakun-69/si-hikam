<?php
namespace App\Traits;

use App\Traits\ResponseOutput;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait FailedValidation{
    use ResponseOutput;
    public function failedValidation(Validator $validator)
    {
        $errors = [];
        $errorMessages = $validator->errors()->messages();
        $keys = array_keys($this->fill);
        foreach ($keys as $key) {
            if(isset($errorMessages[$key])){
                $errors[$key] = collect($errorMessages[$key])->first();
            }
        }
        throw new HttpResponseException($this->responseErrorValidate($errors));
    }
}
