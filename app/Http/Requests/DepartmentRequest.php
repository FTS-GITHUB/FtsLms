<?php

namespace App\Http\Requests;

use App\Traits\Jsonify;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DepartmentRequest extends FormRequest
{
    use Jsonify;

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'department_code' => ['required', 'string', 'max:255'],
            'department_name' => ['required', 'string', 'max:255', 'unique:departments,department_name,NULL,id'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(self::jsonError('Validation failed', $validator->errors(), 422));
    }
}
