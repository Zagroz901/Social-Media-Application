<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function reset(Request $request) {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8',
            'c_passwrod' => 'required|same:password'
        ]);

        $token = $request->input('token');
        if (!$passwordResets = DB::table('password_resets')->where('token',$token)->first()) {
            return response([
                'Message' => 'Invalid token!'
            ],400);
        }
       if( !$user = User::where('email',$passwordResets->email)->first() ) {
            return response([
                'Message' => 'User doesn\'t exists!'
            ],404);
       }

       $user->password = Hash::make($request->input('password'));
       $user->save();

       return response([
        'Message' => 'Success'
       ]);

        // $status = Password::reset(
        //     $request->only('email', 'password', 'password_confirmation', 'token'),
        //     function ($user, $password) {
        //         $user->forceFill([
        //             'password' => Hash::make($password)
        //         ])->setRememberToken(Str::random(60));

        //         $user->save();

        //         event(new PasswordReset($user));
        //     }
        // );

        // return $status === Password::PASSWORD_RESET
        //             ? redirect()->route('login')->with('status', __($status))
        //             : back()->withErrors(['email' => [__($status)]]);
    }
}
