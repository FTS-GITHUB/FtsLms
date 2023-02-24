<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class ForgotPasswordController extends Controller
{
    public function resetPasswordRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return response()->json([
                'message' => 'This email does not exist in our records.',
                'status_code' => 404,
            ], 404);
        } else {
            $random = rand(111111, 999999);
            $user->varification_code = $random;
            if ($user->save()) {
                $userData = [
                    'email' => $user->email,
                    'name' => $user->name,
                    'random' => $random,
                ];
                Mail::send('emails.reset_password', $userData, function ($message) use ($userData) {
                    $message->from('no_reply@firm-tech.com', 'Password Request');
                    $message->to($userData['email'], $userData['name']);
                    $message->subject('Reset Password Request (lms system)');
                });
                if (Mail::flushMacros()) {
                    return response()->json([
                        'message' => 'Some error occured , Please Try again',
                        'status_code' => 500,
                    ], 500);
                } else {
                    return response()->json([
                        'message' => 'we have sent you a varification code to your email address',
                        'status_code' => 200,
                    ], 200);
                }
            } else {
                return response()->json([
                    'message' => 'Some error occured , Please Try again',
                    'status_code' => 500,
                ], 500);
            }
        }
    }

    public function resetPassword(Request $request)
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
