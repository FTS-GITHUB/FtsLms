<?php

namespace App\Http\Requests;

use App\Traits\Jsonify;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MosqueRequest extends FormRequest
{
    use Jsonify;

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'masjid_name' => ['required', 'string', 'max:255', 'unique:mosques,masjid_name'],
            'address' => ['required', 'string', 'max:255'],
            'imame_name' => ['required', 'string', 'max:255'],
            'notice_board' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(self::jsonError('Validation failed', $validator->errors(), 422));
    }
}
