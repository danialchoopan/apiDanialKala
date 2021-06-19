<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About danial kala

danial kala api is a simple api for the [danial kala app](https://github.com/danialchoopan/DanialKala)
i used JWT for token auth 

## how setup project
### run composer comment
```
composer update
```
### migrate tables
```
php artisan migrate
```
this app use sms.ir for sending validation sms code and google gmail api for sending email and idpay 
if you want use defult api add this to the .env file
```
UserApiKey={sms ir}
SecretKey={sms ir}

idPayApiKey={id pay api key}

SMS_DOT_IR_RESTFUL_URL_SEND_SMS=http://RestfulSms.com/api/MessageSend

SMS_DOT_IR_RESTFUL_URL_GET_TOKEN=https://RestfulSms.com/api/Token

GMAIL_USERNAME={your gmail}
GMAIL_PASSWORD={your password}
```
you can use other api services by changing the api/authUserColtroller.php
