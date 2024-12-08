<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * login api .
     */
    public function login(Request $request)
    {
        try{
            $data = User::where('email','=',$request->input('email'))
                ->where('password','=',$request->input('password'))
                ->select('id')->first();
            if($data!==null){
                $token = JWTToken::CreateToken($request->input('email'),$data->id);
                return response()->json([
                    'token' => $token,
                    'message' => 'login success',
                    'success' => true
                ],201)->cookie('token',$token,time()+60*60*24);
            }else{
                return response()->json([
                    'message' => 'login failed',
                    'success' => false
                ],401);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false
            ],500);
        }
    }

    /**
     * register a newly created resource in storage.
     */
    public function register(Request $request)
    {
        try{
            $result = User::create([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'phone'=>$request->input('phone'),
                'password'=>$request->input('password'),
            ]);
            return response()->json([
                'message'=>'User Register successfully',
                'data'=>$result,
                'success'=>true,
            ],201);
        }catch(Exception $e){
            return response()->json([
                'message'=>$e->getMessage(),
                'success'=>false,
            ],500);
        }
    }

    /**
     * User Send OTP user Email.
     */
    public function SendOtpCode(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(100000,999999);
        $count = User::where('email','=',$email)->count();
        if($count==1){
            Mail::to($email)->send(new OTPMail($otp));

            User::where('email','=',$email)->update(['otp'=>$otp]);
            return response()->json([
                'message' => 'OTP sent successfully',
                'status_code' => 201,
                'success' => true
            ],201);
        }else{
            return response()->json([
                'message' => 'User Not Found',
                'status_code' => 404,
                'success' => false
            ],500);
        }
    }

    /**
     * verifyOTP the specified resource in storage.
     */
    public function verifyOTP(Request $request) {
        try{
            $email = $request->input('email');
            $otp = $request->input('otp');
            $count = User::where('email','=',$email)->where('otp','=',$otp)->count();
            if($count==1){
                User::where('email','=',$email)->update(['otp'=>'0']);
                $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
                return response()->json([
                    'message' => 'OTP Verify successfully',
                    'token' => $token,
                    'success' => true
                ],201)->cookie('token',$token,time()+60*60*24);
            }else{
                return response()->json([
                    'message' => 'User Not Found',
                    'status_code' => 404,
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false
            ],500);
        }
    }

    /**
     * resetPassword the specified resource from storage.
     */
    public function resetPassword(Request $request) {
        try{
            $email = $request->header('email');
            $password = $request->input('password');
            $updatePassword = User::where('email','=',$email)->update(['password'=>$password]);
            if($updatePassword){
                return response()->json([
                    'message' => 'Password reset successfully',
                    'status_code' => 201,
                ],201);
            }else{
                return response()->json([
                    'message' => 'User Not Found',
                    'status_code' => 404,
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status_code' => 500

            ],500);
        }
    }
    /*Logout function*/
    public function logOut()
    {
        try{
            return response()->json([
                'message' => 'Logged out successfully',
                'status_code' => 201,
            ],201)->cookie('token','',-1);
        }catch(Exception $e){
            return response()->json([
                'message' => 'User Not Found',
                'status_code' => 500
            ]);
        }
    }
}
