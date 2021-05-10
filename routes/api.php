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

Route::get('category', function () {
    $categories = Category::orderBy('id', 'desc')->get();
    foreach ($categories as $category) {
        $category['category_photo'] = $category->photo->path;
        foreach($category->subCategories as $sub_category){
            $sub_category['sub_category_photo'] = $sub_category->photo->path;
        }
    }
    return $categories;
});

Route::get('categoryproduct/{id}', function ($id) {
    $category = SubCategory::find($id);
    $show_category_api=[];
    $show_category_api['category']=$category;

    $products = $category->products;
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
    return $show_category_api;
});

// show product propertises
Route::get('product/{id}/properties', function ($id) {
    $prodouct = Product::find($id);
    foreach($prodouct->properties_products as $properties){
        $properties->sub_properties_product;
    }
    return $prodouct;
});


Route::get("product/{id}/review", function ($id) {
    $productId = $id;
    $review;
    if(Product::find($id)->review){
        $review = Product::find($id)->review;
    }else{
        $review = Product::find($id)->review()->create([
            'review'=>''
        ]);
    }
    return Product::find($id)->review;
});