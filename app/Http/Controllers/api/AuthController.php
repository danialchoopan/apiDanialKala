<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerifyPhoneNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\Concerns\Has;
use Kavenegar\KavenegarApi;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt_token', ['except' => ['login', 'register', 'checkToken']]);
    }


    public function register(Request $request)
    {
        $credentials = $request->only('name', 'email', 'phone', 'password');
        User::create(array_merge($credentials, ['password' => Hash::make($request->password)]));
        return $this->login($request);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = auth('api')->attempt($credentials)) {
            return response([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }
        return response([
            'success' => true,
            'token' => $token,
            'user' => auth('api')->user(),
            'message' => 'user successfully login in'
        ]);
    }

    public function refresh(Request $request)
    {
        return response([
            'token' => auth('api')->refresh(),
            'user' => Auth::user(),
            'message' => 'user successfully login in'
        ]);
    }


    public function changePassword(Request $request)
    {
        try {
            if (Hash::check($request->oldPassword, auth('api')->user()->getAuthPassword())) {
                $newPassword = Hash::make($request->newPassword);
                $user = auth('api')->user();
                $user->password = $newPassword;
                $user->save();
                return response([
                    'success' => true,
                    'message' => 'رمز عبور شما با موفقیت تغییر کرد'
                ]);
            } else {
                return response([
                    'success' => false,
                    'message' => 'رمزعبور فعلی شما اشتباه است'
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
        $userModel = auth('api')->user();
        if ($userModel->userInfo()) {
            $userModel->userInfo()->create([
                'national_code' => '',
                'state_name' => '',
                'city_name' => '',
                'city_code' => '',
            ]);
        }
        $userModel->userInfo;
        return response([
            'success' => true,
            'user' => $userModel
        ]);
    }

    public function updateUserInfo(Request $request)
    {
        $userModel = auth('api')->user();
        if ($userModel->userInfo()) {
            $user=auth('api')->user();
            $user->name=$request->user_name;
            $user->phone=$request->phone;
            $user->save();  
            $userModel->userInfo()->update([
                'national_code' => $request->national_code,
                'state_name' => $request->state_name,
                'city_name' => $request->city_name,
                'city_code' => $request->city_code,
            ]);
        }
        $userModel->userInfo;
        return response([
            'success' => true,
            'user' => $userModel
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
        $user = User::find(auth('api')->id());
        if ($user->phone_verified) {
            return response(
                [
                    'verified' => true
                ]
            );
        } else {

            return response(
                [
                    'verified' => false
                ]
            );
        }
    }

    public function sendVerifyPhoneSms()
    {
        $code_sms = $this->sms_code_validation_generator(5);
        $message = "code:$code_sms" . "\n" . "کد تایید ارسال شده شما تا 5 دقیقه معتبر است \n دانیال کالا";
        $user = User::find(auth('api')->id());
        //using sms.ir as sms api
        // $responseApiToken=Http::asForm()->withHeaders([
        //     'Content-Type'=>'application/x-www-form-urlencoded'
        //     ])->post("https://RestfulSms.com/api/Token",[
        //     'UserApiKey'=>env('UserApiKey'),
        //     'SecretKey'=>env('SecretKey'),
        // ]);
        // if($responseApiToken->successful()){
            // $response=Http::asForm()->withHeaders([
            //     'Content-Type'=>'application/x-www-form-urlencoded',
            //     'x-sms-ir-secure-token'=>'',

            //     ])->post("http://RestfulSms.com/api/MessageSend",[
            //     'Messages'=>$message,
            //     'MobileNumbers'=>$user->phone,
            //     'LineNumber'=>'30006822885772',
            //     'SendDateTime'=>'',
            // ]);
            // return $response;
        // }
        //expire_time 5m
        $expire_time = time() + 500;
        $user->verifyPhone()->create([
            'code' => $code_sms,
            'expire_time' => $expire_time
        ]);
        return response(
            [
                'success' => true,
                'message' => 'sms sended'
            ]
        );
    }

    public function sendVerifyEmail()
    {
        $code_emial = $this->sms_code_validation_generator(20);
        $message = " ";
        $user = User::find(auth('api')->id());
        //expire_time 1day
        $expire_time = time() + 86400;
        $user->verifyEmail()->create([
            'code' => $code_emial,
            'expire_time' => $expire_time
        ]);
        return response(
            [
                'success' => true,
                'message' => 'email sended'
            ]
        );
    }

    public function confirmVerifyEmail($userCode)
    {
        $user = User::find(auth('api')->id());
        $verify_email_user_model = $user->verifyEmail()->orderBy('id', 'desc')
            ->first();
        if ($verify_email_user_model->expire_time > time()) {
            if ($verify_email_user_model->code == $userCode) {
                $user->email_verified_at = time();
                $user->save();
                return response(
                    [
                        'success' => true,
                        'message' => 'your email number verified',
                        'response_code' => 201
                    ]
                );
            } else {
                return response(
                    [
                        'success' => true,
                        'message' => 'your code is invalid',
                        'response_code' => 202
                    ]
                );
            }
        } else {
            return response(
                [
                    'success' => true,
                    'message' => 'your code is expried',
                    'response_code' => 203
                ]
            );
        }
    }

    public function confirmVerifyPhoneSms(Request $request)
    {
        $user_code = $request->user_code;
        $user = User::find(auth('api')->id());
        $verify_phone_user_model = $user->verifyPhone()->orderBy('id', 'desc')
            ->first();
        if ($verify_phone_user_model->expire_time > time()) {
            if ($verify_phone_user_model->code == $user_code) {
                $user->phone_verified = 1;
                $user->save();
                return response(
                    [
                        'success' => true,
                        'message' => 'your phone number verified',
                        'response_code' => 201
                    ]
                );
            } else {
                return response(
                    [
                        'success' => true,
                        'message' => 'your code is invalid',
                        'response_code' => 202
                    ]
                );
            }
        } else {
            return response(
                [
                    'success' => true,
                    'message' => 'your code is expried',
                    'response_code' => 203
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
