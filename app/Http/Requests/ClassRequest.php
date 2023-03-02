<?php

namespace App\Http\Requests;

use App\Traits\Jsonify;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClassRequest extends FormRequest
{
    use Jsonify;

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'department_id' => ['required', 'string', 'max:255'],
            'course_id' => ['required', 'string', 'max:255'],
            'room' => ['required', 'string', 'max:255'],
            'days' => ['required', 'string', 'max:255'],
            'from' => ['required', 'string', 'max:255'],
            'to' => ['required', 'string', 'max:255'],

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(self::jsonError('Validation failed', $validator->errors(), 422));
    }
}
