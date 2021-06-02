<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>نتیجه تایید حساب کاربری</title>
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
</head>
<body>
@if ($status)
    <div style="text-align: center; padding: 15px;margin:10px;">
        <h2 style="color:green" class="text-success">پست الکترونیک شما با موفقیت تایید شد</h2>
    </div>
@else
    <div style="text-align: center; padding: 15px;margin:10px;">
        <h2 style="color:green" class="text-danger">کد شما منقضی شده است لطفا از داخل برنامه دوباره در خواست بدهید</h2>
    </div>
@endif
</body>
</html>
