<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
class AuthC extends Controller
{
    // register page
    public function register(Request $request) {
        $validate = validator($request->only('email', 'first_name','last_name','gender','birthdate', 'password','c_password'), [
            'first_name' => 'required|string|max:255',
            'last_name' =>'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'gender' => 'required','in:male,female',
            'birthdate' => 'required',
            'password' => 'required|string|min:6',
            'c_password' => 'required|same:password',
        ]);
        if($validate->fails()) {
            return response()->json(['status_code' => 400,$validate->errors()->all()]);
        }
        $user = new User();
        $input = $request->all();
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];
        $user->gender = $input['gender'];
        $user->birthdate = $input['birthdate'];
        $user->password = Hash::make($input['password']);
        $user->save();

        return response()->json(['Token'=>$user->createToken('IbrahimAUTH')->accessToken,'Status_code'=> 200,'message'=>'successfully']);
    }

    // login page
    public function login(Request $request) {
        $validate =  Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',

        ]);
        if($validate->fails()) {
            return response()->json(['Status_code' => 400,$validate->errors()->all()]);
        }
        $cer = request(['email', 'password']);
        if(!Auth::attempt($cer)) {
            return response()->json([
                'status_code' => 500,
                'message' => 'unAuth'
            ]);
        }
        $user = User::where('email','=',$request->email)->first();
        $token = $user->createToken('ibrahimAuth')->accessToken;
        return response()->json([
            'status_code' => 200,
            'token' => $token
        ]);
    }
    public function logout(Request $request) {

        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }



}
