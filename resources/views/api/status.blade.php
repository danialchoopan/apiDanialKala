<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>نتیجه تراکنش</title>
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
</head>
<body>
    @if ($status)
        <div style="text-align: center; padding: 15px;margin:10px;">
            <h2 style="color:green">پرداخت شما با موفقیت انجام شد</h2>
            <p class="mt-3" >شماره سفارش : {{$order_number}}</p>
            <div class="d-grid gap-2">
                <p><a class="btn btn-success mt-2 "
                    href="intent:#Intent;action=ir.danialchoopan.danialkala;category=android.intent.category.DEFAULT;category=android.intent.category.BROWSABLE;S.success=ture;end"
                    >بازگشت به برنامه</a>
            </div>
        </div>
    @else     
        <div style="text-align: center; padding: 15px;margin:10px;">
            <h2 style="color:red">پرداخت شما موفقیت آمیز نبود</h2>
            <p class="mt-3" >شماره سفارش : {{$order_number}}</p>
            <div class="d-grid gap-2">
                <p><a class="btn btn-danger mt-3 "
                    href="intent:#Intent;action=ir.danialchoopan.danialkala;category=android.intent.category.DEFAULT;category=android.intent.category.BROWSABLE;S.success=false;end"
                    >بازگشت به برنامه</a>
            </div>
        </div>
    @endif
</body>
</html>