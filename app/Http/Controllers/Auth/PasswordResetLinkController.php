<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Mail;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return response()->json([
                'message' => 'we have sent you a varification code to your email address',
                'status_code' => 200,
            ], 200);
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

        return response()->json(['status' => __($status)]);
    }
}
