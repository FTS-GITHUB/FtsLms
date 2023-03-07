<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Models\User;
use App\Traits\Jsonify;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    use Jsonify;

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'phone' => $request->phone,
            'type' => $request->type,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        if (auth('sanctum')->check()) {
            auth()->user()->tokens()->delete();
        }

        // $user->token = $user->createToken('auth')->plainTextToken;

        return self::jsonSuccess(message: 'User registered successfully.', data: $user);
    }
}
