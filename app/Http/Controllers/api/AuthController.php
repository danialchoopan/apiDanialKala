<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerifyPhoneNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Kavenegar\KavenegarApi;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt_token', ['except' => ['login', 'register','checkToken']]);
    }


    public function register(Request $request)
    {
        $credentials = $request->only('name', 'email','phone', 'password');
        User::create(array_merge($credentials, ['password' => Hash::make($request->password)]));
        return $this->login($request);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = auth()->attempt($credentials)) {
            return response([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }
        return response([
            'success' => true,
            'token' => $token,
            'user' => Auth::user(),
            'message' => 'user successfully login in'
        ]);
    }

    public function refresh(Request $request)
    {
        return response([
            'token' => auth()->refresh(),
            'user' => Auth::user(),
            'message' => 'user successfully login in'
        ]);
    }


    public function changePassword(Request $request)
    {
        try {
            if (Hash::check($request->oldPassword, Auth::user()->getAuthPassword())) {
                $newPassword = Hash::make($request->newPassword);
                $user = Auth::user();
                $user->password = $newPassword;
                $user->save();
                return response([
                    'success' => true,
                    'message' => 'change password successfully'
                ]);
            } else {
                return response([
                    'success' => false,
                    'message' => 'old password not match'
                ]);
            }
        } catch (\Exception $exception) {
            return response([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function checkToken()
    {
        return response([
            'success' => true
        ]);
    }
    
    public function getUserInfo()
    {
        $userModel=Auth::user();
        if($userModel->userInfo()){
            $userModel->userInfo()->create([
                'national_code'=>'',
                'state_name'=>'',
                'city_name'=>'',
                'city_code'=>'',
            ]);
        }
        $userModel->userInfo;
        return response([
            'success' => true,
            'user'=>$userModel
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response([
            'success' => true,
            'message' => 'Successfully logged out']);
    }


    
    public function checkIfPhoneVerified()
    {
        $user=Auth::user();
        if($user->phone_verified){
            return response(
                [
                     'verified'=>true
                ]
            );
        }else{
            
        return response(
                [
                    'verified'=>false
                ]
            );
        }
    }

    public function sendVerifyPhoneSms(){
        $code_sms = $this->sms_code_validation_generator(5);
        $sender = "1000596446";
        $receptor = "09216059177";
        $message = "code:$code_sms" . "\n" . "کد تایید ارسال شده شما تا 5 دقیقه معتبر است \n دانیال کالا";
        $api = new KavenegarApi(env('KAVENEGAR_API_KEY'));
        // $api->Send($sender, $receptor, $message);
        //expire_time 5m
        $expire_time = time() + 500;
        Auth::user()->verifyPhone()->create([
            'code'=>$code_sms,
            'expire_time'=>$expire_time
        ]);
        return response(
            [
                'success'=>true,
                 'message'=>'sms sended'
            ]
        );
    }


    public function confirmVerifyPhoneSms(Request $request){
        $user_code=$request->user_code;
        $user=Auth::user();
        $verify_phone_user_model=$user->verifyPhone()->orderBy('id', 'desc')
        ->first();
        if($verify_phone_user_model->expire_time > time()){
            if($verify_phone_user_model->code == $user_code){
                $user->phone_verified=1;
                $user->save();
                return response(
                    [
                        'success'=>true,
                        'message'=>'your phone number verified',
                        'response_code'=>201
                    ]
                );
            }else{
                return response(
                    [
                        'success'=>true,
                        'message'=>'your code is invalid',
                        'response_code'=>202
                    ]
                );
            }
        }else{
            return response(
                    [
                        'success'=>true,
                        'message'=>'your code is expried',
                        'response_code'=>203
                    ]
                );
        }
    }
    public function sms_code_validation_generator($length = 6)
    {
        $code = '';
        $number = '1234567890';
        $number = str_shuffle(str_shuffle(rand(1, 999999) . $number . rand(1, 999999) . $number . rand(1, 999999) . $number . rand(1, 999999) . $number));
        $ar_numbers = str_split($number);
        for ($i = 0; $i <= $length; $i++) {
            $code .= $ar_numbers[$i];
        }
        return $code;
    
    }

}
