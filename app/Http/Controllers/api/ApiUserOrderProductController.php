<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\UserProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiUserOrderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = auth('api')->user()->orders;
        return response($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $carts = auth('api')->user()->cart;
        $user = auth('api')->user();
        $cart_products = [];
        $numberOrder = $this->sms_code_validation_generator(20);
        $amount = $request->amount;
        foreach ($carts as $cart) {
            UserProductOrder::create([
                'user_id' => $cart->user_id,
                'product_id' => $cart->product_id,
                'order_product_id' => $numberOrder
            ]);
        }
        $carts = auth('api')->user()->cart()->delete();
        $order = Order::create([
            'order_product_id' => $numberOrder,
            'status' => 0,
            'price' => $amount,
            'description' => $request->description,
            'user_addesse_id' => $request->address_id,
            'user_id' => $user->id
        ]);

        //send user to the payment link
        $responseIdPay = Http::withHeaders([
            'X-SANDBOX' => 'true',
            'Content-Type' => 'application/json',
            'X-API-KEY' => env('idPayApiKey')
        ])->post('https://api.idpay.ir/v1.1/payment', [
            'order_id' => $numberOrder,
            'amount' => $amount,
            'name' => $user->name,
            'phone' => $user->phone,
            'mail' => $user->email,
            'callback' => env('APP_URL') . 'api/idpaytest'
        ]);
        if ($responseIdPay->successful()) {
            $order->id_transaction = $responseIdPay['id'];
            $order->link_transaction = $responseIdPay['link'];
            $order->save();
            return response($responseIdPay);
        }
        return response([
            'url' => 'error'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productOrders = UserProductOrder::where('order_product_id', $id)->get();
        $products = [];
        foreach ($productOrders as $productOrder) {
            $product = Product::find($productOrder->product_id);
            foreach ($product->Productphotos as $productphoto) {
                if ($productphoto->thumbnail == 1) {
                    $product['thumbnail'] = 'img/' . $productphoto->path;
                }
            }
            $product['price'] = $product->stores[0]->price_sell;
            $subCategory = SubCategory::find($product->subCategory_id);
            $product['category'] = $subCategory->category->name;
            $product['Subcategory'] = $subCategory->name;
            $products[] = $product;
        }
        return $products;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
