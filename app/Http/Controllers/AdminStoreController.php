<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class AdminStoreController extends Controller
{
    public function index($id_product)
    {
        $product = Product::find($id_product);
        return view('admin.products.store.index', [
            'stores' => $product->stores,
            'id_product' => $product->id
        ]);
    }

    public function delete($id)
    {
        $store = Store::find($id);
        $id_product = $store->product->id;
        $store->delete();
        return redirect()->route('store.index', $id_product);
    }

    public function create($id_product)
    {
        return view('admin.products.store.create', [
            'id_product' => $id_product,
            'colors' => Color::all()
        ]);
    }

    public function store($id_product, Request $request)
    {
        $product = Product::find($id_product);
        $create_store = [
            'color_id' => $request->product_color,
            'count' => $request->store_number,
            'warranty' => $request->store_warranty,
            'price_buy' => $request->store_price_buy,
            'price_sell' => $request->store_price_sell
        ];
        $product->stores()->create($create_store);
        return redirect()->route('store.index', $id_product);
    }
}
