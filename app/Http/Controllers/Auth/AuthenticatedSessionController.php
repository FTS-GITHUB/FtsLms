<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    use Jsonify;

    public function store(LoginRequest $request)
    {
        try {
            if (! Auth::attempt(['email' => $request->email, 'password' => $request->password, 'state' => 'active'])) {
                return self::jsonError(message: 'Incorrect email or password.', code: 401);
            }
            $user = $request->user();

            $user->token = $user->createToken($request->token_name ?? 'authenticated');

            return self::jsonSuccess(message: 'User logged in successfully.', data: $user, code: 200);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Request $request)
    {

        Auth::guard('web')->logout();

        $request->user()->tokens()->delete();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return self::jsonSuccess(message: 'User logged out successfully.', code: 200);
    }
}
