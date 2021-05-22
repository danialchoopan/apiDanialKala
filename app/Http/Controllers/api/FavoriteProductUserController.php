<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\FavoriteProduct;
use App\Models\Product;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;

class FavoriteProductUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userModel=auth('api')->user();
        $products=[];
        foreach ($userModel->favoriteProduct as $favoriteProduct) {
            $product = Product::find($favoriteProduct->product_id);
            foreach ($product->Productphotos as $productphoto) {
                if ($productphoto->thumbnail == 1) {
                    $product['thumbnail'] = 'img/' . $productphoto->path;
                }
            }
            $product['price'] = $product->stores[0]->price_sell;
            $subCategory = SubCategory::find($product->subCategory_id);
            $product['category'] = $subCategory->category->name;
            $product['Subcategory'] = $subCategory->name;
            $products[]=$product;
        }
        return $products;


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userModel=auth('api')->user();
        $product_id=$request->product_id;
        $user_id= $userModel->id;
        $favoriteProduct = FavoriteProduct::where('product_id', $product_id)->where('user_id', $user_id)->get();
        if (count($favoriteProduct)) {
            $favoriteProduct[0]->delete();
            return response()->json([
                'favorite' => false
            ]);
        }
        FavoriteProduct::create([
            'product_id' => $product_id,
            'user_id' => $user_id
        ]);
        return response()->json([
            'favorite' => true
        ]);
    }

    public function checkFavorite(Request $request){
        $userModel=auth('api')->user();
        $product_id=$request->product_id;
        $user_id= $userModel->id;
        $favoriteProduct = FavoriteProduct::where('product_id', $product_id)->where('user_id', $user_id)->get();
        if (count($favoriteProduct)) {
            return response()->json([
                'favorite' => true
            ]);
        }else{
            return response()->json([
                'favorite' => false
            ]);
        }
    }
}
