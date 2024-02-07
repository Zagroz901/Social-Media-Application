<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class ForgotPasswordController extends Controller
{

    public function forgot(Request $request) {

        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->input('email');

        if(User::where('email',$email)->doesntExist()) {
            return response([
                'Message' => 'User doen\'t exists'
            ],400);
        }
        $token = Str::random(5);

        try {
              //because don't have a model for password
        DB::table('password_resets')->insert([
            'Email' => $email,
            'Token' => $token
        ]);

        //Send email
        Mail::send('Mails',['token' => $token],function(Message $message) use ($email) {
            $message->to($email);
            $message->subject('Reset your password');
        });
        return response([
            'Message' => 'Check your email'
        ]);

    }catch(Exception $exception) {
           return response([
            'Message' => $exception->getMessage()
        ],404);
    }


        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );

        // return $status === Password::RESET_LINK_SENT
        //             ? back()->with(['status' => __($status)])
        //             : back()->withErrors(['email' => __($status)]);

    }

}
