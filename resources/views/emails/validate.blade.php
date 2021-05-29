<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <p>برای تایید حساب کاربری خود روی لینک زیر کلیک کنید</p>
    <br>
    <a href="{{env('APP_URL')}}api/auth/user/confirmVerifyEmail/{{ $details['validate_code'] }}/{{$details['user_id']}}">تایید حساب</a>
    <br>
    <p>اگر لینک بالا کار نکرد از لینک زیر استفاده کنید</p>
    <br>
    {{env('APP_URL')}}api/auth/user/confirmVerifyEmail/{{ $details['validate_code'] }}/{{$details['user_id']}}
</body>
</html>