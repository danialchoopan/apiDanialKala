<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Slider;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
    $products = Product::orderBy('id', 'desc')->get();
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
    $home_api['home_slider'] = $sliders;
    $home_api['categories'] = $categories;
    $home_api['new_products'] = $products;
    return $home_api;
});
Route::get('cat', function () {
    return Category::all();
});
Route::get('subcat/{cat_id}', function ($cat_id) {
    return Category::find($cat_id)->subCategorys;
});
