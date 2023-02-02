<?php

namespace App\Http\Requests;

use App\Traits\Jsonify;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class QuranicRequest extends FormRequest
{
    use Jsonify;

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'qari_name' => ['required', 'string'],
            'surah_name' => ['required', 'string', 'max:255'],
            'para_number' => ['required', 'string'],
            'tag_name' => ['required', 'string', 'max:255'],
            ['audio' => 'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(self::jsonError('Validation failed', $validator->errors(), 422));
    }
}
