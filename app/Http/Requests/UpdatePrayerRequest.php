<?php

namespace App\Http\Requests;

use App\Traits\Jsonify;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePrayerRequest extends FormRequest
{
    use Jsonify;

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'mosque_id' => ['required',  'max:255', 'mosques:blogs,title'],
            'fajar' => ['required', 'string', 'max:255'],
            'zuhar' => ['required', 'string', 'max:255'],
            'asar' => ['required', 'string', 'max:255'],
            'maghrib' => ['required', 'string', 'max:255'],
            'Isha' => ['required', 'string', 'max:255'],
            'al_juma' => ['required', 'string', 'max:255'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(self::jsonError('Validation failed', $validator->errors(), 422));
    }
}
