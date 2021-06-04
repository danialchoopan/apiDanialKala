<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\MailValidateUser;
use App\Models\VerifyEmail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerifyPhoneNumber;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Testing\Fluent\Concerns\Has;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt_token', ['except' => ['login', 'register', 'checkToken', 'changePasswordForgot', 'checkUserPhoneForForgotPassword', 'sendVerifyPhoneSmsForgotPassword', 'confirmVerifyPhoneSmsForgotPassword', 'confirmVerifyEmail']]);
    }


    public function register(Request $request)
    {
        $request->validate([
            'phone' => 'unique:users',
            'email' => 'unique:users'
        ]);
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
            $user = auth('api')->user();
            $user->name = $request->user_name;
            $user->phone = $request->phone;
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


    public function checkUserPhoneForForgotPassword(Request $request)
    {
        try {
            $user = User::where('phone', $request->phone)->get()->first();
            if ($user) {
                return response(
                    ['success' => true]
                );
            } else {
                return response(['success' => false]);
            }
        } catch (Exception $e) {
            return response(['success' => false]);
        }
    }

    public function changePasswordForgot(Request $request)
    {
        try {
            $newPassword = Hash::make($request->password);
            $user = User::where('phone', $request->phone)->get()->first();
            $user->password = $newPassword;
            $user->save();
            return response([
                'success' => true,
                'message' => 'رمز عبور شما با موفقیت تغییر کرد'
            ]);
        } catch (\Exception $exception) {
            return response([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function sendVerifyPhoneSmsForgotPassword(Request $request)
    {
        $code_sms = $this->sms_code_validation_generator(5);
        $message = "code:$code_sms" . "\n" . "کد تایید ارسال شده شما تا 5 دقیقه معتبر است \n دانیال کالا";
        $user = User::where('phone', $request->phone)->get()->first();
        //using sms.ir as sms api
        $responseApiToken=Http::asForm()->withHeaders([
            'Content-Type'=>'application/x-www-form-urlencoded'
            ])->post(env('SMS_DOT_IR_RESTFUL_URL_GET_TOKEN'),[
            'UserApiKey'=>env('UserApiKey'),
            'SecretKey'=>env('SecretKey'),
        ]);
        if($responseApiToken->successful()){
            $response=Http::asForm()->withHeaders([
                'Content-Type'=>'application/x-www-form-urlencoded',
                'x-sms-ir-secure-token'=>$responseApiToken['TokenKey'],
                ])->post(env('SMS_DOT_IR_RESTFUL_URL_SEND_SMS'),[
                'Messages'=>$message,
                'MobileNumbers'=>$user->phone,
                'LineNumber'=>'30006822885772',
                'SendDateTime'=>'',
            ]);
        }
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

    public function confirmVerifyPhoneSmsForgotPassword(Request $request)
    {
        $user_code = $request->code;
        $user = User::where('phone', $request->phone)->get()->first();
        $verify_phone_user_model = $user->verifyPhone()->orderBy('id', 'desc')
            ->first();
        if ($verify_phone_user_model->expire_time > time()) {
            if ($verify_phone_user_model->code == $user_code) {
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
        $responseApiToken=Http::asForm()->withHeaders([
            'Content-Type'=>'application/x-www-form-urlencoded'
            ])->post(env('SMS_DOT_IR_RESTFUL_URL_GET_TOKEN'),[
            'UserApiKey'=>env('UserApiKey'),
            'SecretKey'=>env('SecretKey'),
        ]);
        if($responseApiToken->successful()){
            $response=Http::asForm()->withHeaders([
                'Content-Type'=>'application/x-www-form-urlencoded',
                'x-sms-ir-secure-token'=>$responseApiToken['TokenKey'],
                ])->post(env('SMS_DOT_IR_RESTFUL_URL_SEND_SMS'),[
                'Messages'=>$message,
                'MobileNumbers'=>$user->phone,
                'LineNumber'=>'30006822885772',
                'SendDateTime'=>'',
            ]);
        }
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
        $code_email = $this->sms_code_validation_generator(20);
        $message = " ";
        $user = User::find(auth('api')->id());
        //expire_time 1day
        $expire_time = time() + 86400;
        $user->verifyEmail()->create([
            'code' => $code_email,
            'expire_time' => $expire_time
        ]);
        //send email
        $details = [
            'user_id' => $user->id,
            'validate_code' => $code_email
        ];
        $validation_url = env('APP_URL') . 'api/auth/user/confirmVerifyEmail/' . $details['validate_code'] . '/' . $details['user_id'];
        $email_body = "
<center>
        دانیال کالا
        <br>
        برای تایید حساب خود روی لینک زیر کلیک کنید
        <br>
        <a href='$validation_url'>تایید حساب کاربری</a>

        <br>
        " . $validation_url . '</center>';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '465';
        $mail->isHTML(true);
        $mail->Username = env('GMAIL_USERNAME');
        $mail->Password = env('GMAIL_PASSWORD');
        $mail->setFrom('no-reply@danialchoopan.ir');
        $mail->Subject = 'validate email danial kala';
        $mail->Body = $email_body;
        $mail->addAddress($user->email);
        $mail->send();
        return response(
            [
                'success' => true,
                'message' => 'email sended'
            ]
        );
    }

    public function confirmVerifyEmail($userCode, $userId)
    {
        $verify_email_user_model = VerifyEmail::where('code', $userCode)->orderBy('id', 'desc')->first();
        if ($verify_email_user_model) {
            if ($verify_email_user_model->expire_time > time()) {
                if ($verify_email_user_model->code == $userCode) {
                    $user = User::find($userId);
                    $user->email_verified_at = time();
                    $user->save();
                    return view('api.emailStatus', ['status' => true]);
//                    return response(
//                        [
//                            'success' => true,
//                            'message' => 'پست الکترونیک شما با موفقیت تایید شد',
//                            'response_code' => 201
//                        ]
//                    );
                }
            } else {
                return view('api.emailStatus', ['status' => false]);
//                return response(
//                    [
//                        'success' => true,
//                        'message' => 'کد شما منقضی شده است',
//                        'response_code' => 203
//                    ]
//                );
            }
        } else {
            return view('api.emailStatus', ['status' => false]);
//            return response(
//                [
//                    'success' => true,
//                    'message' => 'کد شما اشتباه است',
//                    'response_code' => 202
//                ]
//            );
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
