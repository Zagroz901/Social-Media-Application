<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;

class EmailVerificationController extends Controller
{


//use EmailVerificationRequest;

   /* public function __construct()
    {
        $this->middleware('auth:api')->only('sendverificationEmail');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify','sendverificationEmail');
    }*/

    //send link verification email
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {

            return response(['Message'=>'Already verified']);
        }

        $request->user()->sendEmailVerificationNotification();

        if ($request->wantsJson()) {
            return response(['Message' => 'Email Sent']);
        }

        return response( [
            "Message" => "link go your account"
        ] );

       // return back()->with('resent', true);
    }


    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
       // auth()->loginUsingId($request->route('id'));

        if ($request->route('id') != $request->user()->getKey()) { // $request->user()->getKey() return id the user email
            //throw new AuthorizationException;

            return response( [
                'Error' => 'The ID you sent is invalid'
            ] );

            // return response([
            //     'nnnnnnn' => 'sdsad'
            // ,'sss'=>$request->user()->getKey()]);
        }

        if ($request->user()->hasVerifiedEmail()) {

            return response(['Message'=>'Already verified']);

            // return redirect($this->redirectPath());
        }

        if ($request->user()->markEmailAsVerified()) { // Mark the given user's email as verified.
           event(new Verified($request->user()));
        }

        return response(['Message'=>'Successfully verified']);

    }


  /*  public function verify(EmailVerificationRequest  $request) {

        auth()->loginUsingId( $request->route('id') );
        if ( $request->route('id') != $request->user()->getKey() ) {
            throw new AuthorizationException;
        }
        if ( $request->user()->hasVerifiedEmail() ) {
            return response( [
                'Message' => 'Already Verified'
            ] );

           // return redirect( $this->redirectPath() );
        }

        if ( $request->use()->markEmailAsVerified() ) {

            event( new Verified( $request->user() ) );
        }

        return response( [
            'Messgae' => 'Successfully verified'
        ] );
        //return redirect( $this->redirectPath() )->with('verified', true);
    }*/





     // verify email
   /* public function verify(Request $request) {

        if ( $request->user()->hasVerifiedEmail() ) {
            return [
                'Message' => 'Email Already Verified'
            ];
        }

        if ( $request->use()->markEmailAsVerified() ) {
            event( new Verified( $request->user() ) );
        }

         return [
            'Message' => 'Email has been verified'
         ];

    }*/

}
