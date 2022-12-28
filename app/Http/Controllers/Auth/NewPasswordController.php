<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'varification_code' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::where('email', $request->email)->where('varification_code', $request->varification_code)->first();
        if (! $user) {
            return response()->json([
                'message' => 'User not found / Invalid code',
                'status_code' => 401,
            ], 401);
        } else {
            $user->password = bcrypt(trim($request->password));
            $user->varification_code = null;
            if ($user->save()) {
                return response()->json([
                    'message' => 'Password Updated Successfully',
                    'status_code' => 200,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Some error occured , please try again',
                    'status_code' => 500,
                ], 500);
            }
        }
    }
}
