<?php

namespace App\Http\Requests\Permissions\Users;

use App\Traits\Jsonify;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    use Jsonify;

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $id = $this->route('user')->id;

        return [
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', "unique:users,email,{$id},id,deleted_at,NULL"],
            'password' => [Password::defaults()],
            'roles' => ['array'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(self::jsonError('Validation failed', $validator->errors(), 422));
    }
}
