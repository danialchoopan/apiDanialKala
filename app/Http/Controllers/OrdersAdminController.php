<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\UserProductOrder;
use Illuminate\Http\Request;

class OrdersAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=Order::all();
        return view('admin.orders.index',['orders'=>$orders]);
    }

    public function showByStatus($status){
        if ($status==100){
            $orders=Order::where('status',100)->get();
        }else{
            $orders=Order::where('status','!=',100)->get();
        }
        return view('admin.orders.index',['orders'=>$orders]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
        return view('admin.orders.show',['productOrders'=>$products]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
