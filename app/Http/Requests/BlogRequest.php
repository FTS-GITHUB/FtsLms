<?php

namespace App\Http\Requests;

use App\Traits\Jsonify;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BlogRequest extends FormRequest
{
    use Jsonify;

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'string'],
            'title' => ['required', 'string', 'unique:blogs,title'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(self::jsonError('Validation failed', $validator->errors(), 422));
    }
}
