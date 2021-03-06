<?php

use App\Http\Controllers\api\ApiAddessController;
use App\Http\Controllers\api\ApiProductCommentController;
use App\Http\Controllers\api\ApiProductController;
use App\Http\Controllers\api\ApiUserCartController;
use App\Http\Controllers\api\ApiUserOrderProductController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\FavoriteProductUserController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\FavoriteProduct;
use App\Models\Product;
use App\Models\Slider;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('home', function () {
    $home_api = [];
    $sliders = Slider::orderBy('id', 'desc')->get();
    foreach ($sliders as $slider) {
        $slider['slider_photo'] = $slider->photo->path;
    }
    $categories = Category::orderBy('id', 'desc')->get();
    foreach ($categories as $category) {
        $category['category_photo'] = $category->photo->path;
    }
    $products = Product::orderBy('id', 'desc')->take(7)->get();
    foreach ($products as $product) {
        if ($product->Productphotos) {
            foreach ($product->Productphotos as $productphoto) {
                if ($productphoto->thumbnail == 1) {
                    $product['thumbnail'] = 'img/' . $productphoto->path;
                }
            }
        } else {
            $product['thumbnail'] = "";
        }
        $product['price'] = $product->stores[0]->price_sell;
        $subCategory = SubCategory::find($product->subCategory_id);
        $product['category'] = $subCategory->category->name;
        $product['Subcategory'] = $subCategory->name;

        $product['brand'] = Brand::find($product->brand_id);
        $colors = [];
        foreach (unserialize($product->colors) as $key => $value) {
            $color_id = (int)$value;
            $colors[] = Color::find($color_id);

        }
        $product['colors'] = $colors;
    }
    $home_api['home_slider'] = $sliders;
    $home_api['categories'] = $categories;
    $home_api['new_products'] = $products;
    return $home_api;
});
//show single product
Route::get('product/{id}', function ($id) {
    $product = Product::find($id);
    if (isset($product->Productphotos)) {
        foreach ($product->Productphotos as $productphoto) {
            if ($productphoto->thumbnail == 1) {
                $product['thumbnail'] = 'img/' . $productphoto->path;
            }
        }
    } else {
        $product['thumbnail'] = "";
    }
    $product['price'] = $product->stores[0]->price_sell;
    $subCategory = SubCategory::find($product->subCategory_id);
    $product['category'] = $subCategory->category->name;
    $product['Subcategory'] = $subCategory->name;
    return $product;

});
Route::get('category', function () {
    $categories = Category::orderBy('id', 'desc')->get();
    foreach ($categories as $category) {
        $category['category_photo'] = $category->photo->path;
        foreach ($category->subCategories as $sub_category) {
            $sub_category['sub_category_photo'] = $sub_category->photo->path;
        }
    }
    return $categories;
});

Route::get('subCategory/{id}', function ($id) {
    $subCategories = Category::find($id)->subCategories;
    foreach ($subCategories as $subCategory) {
        $subCategory->photo->path;
    }
    return $subCategories;
});

Route::get('categoryproduct/{id}', function ($id) {
    $category = SubCategory::find($id);
    $show_category_api = [];
    $show_category_api['category'] = $category;

    $products = $category->products;
    foreach ($products as $product) {
        if ($product->Productphotos) {
            foreach ($product->Productphotos as $productphoto) {
                if ($productphoto->thumbnail == 1) {
                    $product['thumbnail'] = 'img/' . $productphoto->path;
                }
            }
        } else {
            $product['thumbnail'] = "";
        }
        $product['price'] = $product->stores[0]->price_sell;
        $subCategory = SubCategory::find($product->subCategory_id);
        $product['category'] = $subCategory->category->name;
        $product['Subcategory'] = $subCategory->name;

        $product['brand'] = Brand::find($product->brand_id);
        $colors = [];
        foreach (unserialize($product->colors) as $key => $value) {
            $color_id = (int)$value;
            $colors[] = Color::find($color_id);

        }
        $product['colors'] = $colors;
    }
    return $show_category_api;
});

// show product propertises
Route::get('product/{id}/properties', function ($id) {
    $prodouct = Product::find($id);
    foreach ($prodouct->properties_products as $properties) {
        $properties->sub_properties_product;
    }
    return $prodouct;
});


Route::get("product/{id}/review", function ($id) {
    $productId = $id;
    $review;
    if (Product::find($id)->review) {
        $review = Product::find($id)->review;
    } else {
        $review = Product::find($id)->review()->create([
            'review' => ''
        ]);
    }
    return Product::find($id)->review;
});


//user auth api route
Route::post('auth/user/register', [AuthController::class, 'register']);
Route::post('auth/user/login', [AuthController::class, 'login']);
Route::post('auth/user/checkToken', [AuthController::class, 'checkToken']);
Route::post('auth/user/getUserInfo', [AuthController::class, 'getUserInfo']);
Route::patch('auth/user/updateUserInfo', [AuthController::class, 'updateUserInfo']);
//change password
Route::post('auth/user/changePassword', [AuthController::class, 'changePassword']);

//verify phone number
Route::post('auth/user/checkIfPhoneVerified', [AuthController::class, 'checkIfPhoneVerified']);
Route::post('auth/user/sendVerifyPhoneSms', [AuthController::class, 'sendVerifyPhoneSms']);
Route::post('auth/user/confirmVerifyPhoneSms', [AuthController::class, 'confirmVerifyPhoneSms']);
//verify email
Route::post('auth/user/sendVerifyEmail', [AuthController::class, 'sendVerifyEmail']);
Route::get('auth/user/confirmVerifyEmail/{userCode}/{userId}', [AuthController::class, 'confirmVerifyEmail']);

//forgot password
Route::post('auth/user/checkUserPhoneForForgotPassword', [AuthController::class, 'checkUserPhoneForForgotPassword']);
Route::post('auth/user/sendVerifyPhoneSmsForgotPassword', [AuthController::class, 'sendVerifyPhoneSmsForgotPassword']);
Route::post('auth/user/confirmVerifyPhoneSmsForgotPassword', [AuthController::class, 'confirmVerifyPhoneSmsForgotPassword']);
Route::post('auth/user/changePasswordForgot', [AuthController::class, 'changePasswordForgot']);


//end user auth api route

Route::group(['middleware' => ['jwt_token']], function () {
    //addess
    Route::apiResource('user/addess', ApiAddessController::class);
    Route::apiResource('user/cart', ApiUserCartController::class);
    //favorite product
    Route::post('favorite/product/all', [FavoriteProductUserController::class, 'index']);
    Route::post('favorite/product', [FavoriteProductUserController::class, 'store']);
    Route::post('favorite/product/check', [FavoriteProductUserController::class, 'checkFavorite']);
    //user order
    Route::apiResource('user/order', ApiUserOrderProductController::class);
});
Route::apiResource('product/comment', ApiProductCommentController::class);

Route::post('product/search', [ApiProductController::class, 'search']);
Route::get('show/all/product', [ApiProductController::class, 'index']);

Route::get('states/', function () {
    $states = DB::select('select * from `locate` where `subid` = ?', [1]);
    return response($states);
});
Route::get('states/{id}', function ($id) {
    $cities = DB::select('select * from `locate` where `subid` = ?', [$id]);
    return response($cities);
});

Route::post('idpaytest', function (Request $request) {
    $order = \App\Models\Order::where('order_product_id', $request->order_id)->get()->first();
    $order->status = $request->status;
    $order->save();
    if($request->status==10){
        $order = \App\Models\Order::where('order_product_id', $request->order_id)->get()->first();
        //send user to the payment link
        $responseIdPay = Http::withHeaders([
            'X-SANDBOX' => 'true',
            'Content-Type' => 'application/json',
            'X-API-KEY' => env('idPayApiKey')
        ])->post('https://api.idpay.ir/v1.1/payment/verify', [
            'id' => $order->id_transaction,
            'order_id' => $order->order_product_id,
        ]);
        if ($responseIdPay->successful()) {
            if($responseIdPay['status']==101){
                return
                "<h1><center>" .
                "???????????? ?????? ???????? ?????????? ?????? ??????"
                . "</center></h1>";
            }
            if ($responseIdPay['status'] == 100) {
                $orderNew = \App\Models\Order::where('order_product_id', $request->order_id)->get()->first();
                $orderNew->status = 100;
                $orderNew->save();
                return view('api.status',['status' =>true,'order_number'=>$order->order_product_id]);
            } else {
                return view('api.status',['status' =>false,'order_number'=>'error']);
            }
        }else {
            return view('api.status',['status' =>false,'order_number'=>'error']);
        }
    }else {
        return view('api.status',['status' =>false,'order_number'=>'error']);
    }
});

Route::get('sende321mail', function () {
    $data = array('name'=>"Virat Gandhi");
    Mail::send(['text'=>'mail'], $data, function($message) {
        $message->to('abc@gmail.com', 'Tutorials Point')->subject
        ('Laravel Basic Testing Mail');
        $message->from('xyz@gmail.com','Virat Gandhi');
    });
});