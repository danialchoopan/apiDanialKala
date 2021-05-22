<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\UserCart;
use Exception;
use Illuminate\Http\Request;

class ApiUserCartController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts=auth('api')->user()->cart;
        $cart_products=[];
        foreach ($carts as $cart) {
            $product = Product::find($cart->product_id);
            foreach ($product->Productphotos as $productphoto) {
                if ($productphoto->thumbnail == 1) {
                    $product['thumbnail'] = 'img/' . $productphoto->path;
                }
            }
            $product['price'] = $product->stores[0]->price_sell;
            $subCategory = SubCategory::find($product->subCategory_id);
            $product['category'] = $subCategory->category->name;
            $product['Subcategory'] = $subCategory->name;
            $product['cart']=$cart;
            $cart_products[]=$product;
        }
        return $cart_products;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            auth('api')->user()->cart()->create([
                'product_id'=>$request->product_id
            ]);
            return response([
                'success'=>true
            ]);
        }catch(Exception $e){
            return response([
                'success'=>false,
                'message'=>$e
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carts=auth('api')->user()->cart;
        foreach($carts as $cart){
            if($cart->product_id==$id){
                return response([
                    'success'=>true
                ]);
            }
        }        
        return response([
            'success'=>false
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart=UserCart::find($id);
        $cart->delete();
        return response([
            'success'=>true
        ]);
    }
}
