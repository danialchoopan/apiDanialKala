<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;

class ApiProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        foreach ($products as $product) {
            if($product->Productphotos){
                foreach ($product->Productphotos as $productphoto) {
                    if ($productphoto->thumbnail == 1) {
                        $product['thumbnail'] = 'img/' . $productphoto->path;
                    }
                }
            }else{
                $product['thumbnail']="";
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
        return response($products);
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

    public function search(Request $request){
        try{
            $products=Product::where('name','like','%'.$request->queryProduct.'%')->get();
            foreach ($products as $product) {
                foreach ($product->Productphotos as $productphoto) {
                    if ($productphoto->thumbnail == 1) {
                        $product['thumbnail'] = 'img/' . $productphoto->path;
                    }
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
            return $products;
        }catch(Exception $e){

        }
    }
}
