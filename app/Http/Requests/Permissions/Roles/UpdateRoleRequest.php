<?php

namespace App\Http\Requests\Permissions\Roles;

use App\Traits\Jsonify;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class UpdateRoleRequest extends FormRequest
{
    use Jsonify;

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'permissions' => ['array', 'nullable'],
            'permissions.*' => ['exists:permissions,id'],
        ];
    }

    public function attributes()
    {
        return ['permissions.*' => 'permission'];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(self::jsonError('Validation failed', $validator->errors(), 422));
    }
}
