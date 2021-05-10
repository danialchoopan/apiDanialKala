<?php

use App\Http\Controllers\AdminBrandController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminColorController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminSliderController;
use App\Http\Controllers\AdminStoreController;
use App\Http\Controllers\AdminSubCategoryController;
use App\Http\Controllers\AdminUserController;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\PropertiesProduct;
use App\Models\Review;
use App\Models\SubPropertiesProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'adminUser']], function () {
    Route::get("/", function () {
        return view("admin.index");
    })->name("home.admin");

    Route::resource('user', AdminUserController::class);
    Route::resource('category', AdminCategoryController::class);
    Route::resource('sub_category', AdminSubCategoryController::class);
    Route::resource('products', AdminProductController::class);
    Route::resource('color', AdminColorController::class);
    Route::resource('brand', AdminBrandController::class);
    Route::resource('slider', AdminSliderController::class);

    Route::get('store/{id_product}', [AdminStoreController::class, 'index'])->name('store.index');
    Route::delete('store/{id}', [AdminStoreController::class, 'delete'])->name('store.delete');
    Route::get('store/{id_product}/create', [AdminStoreController::class, 'create'])->name('store.create');
    Route::post('store/{id_product}', [AdminStoreController::class, 'store'])->name('store.store');


    Route::get("product/{id}/properties", function ($id) {
        $prodouct = Product::find($id);
        $properties = $prodouct->properties_products;
        return view("admin.products.properties.index", compact('properties', "id"));
    })->name("product.properties.index");

    Route::post("product/{id}/properties", function ($id, Request $request) {
        $prodouct = Product::find($id);
        $prodouct->properties_products()->create($request->all());
        return redirect()->route("product.properties.index", $id);
    })->name("product.properties.store");


    Route::delete("product/properties/{id}", function ($id, Request $request) {
        $propertiesProduct = PropertiesProduct::find($id);
        $propertiesProduct->delete();
        return redirect()->route("product.properties.index", $request->id_product);
    })->name("product.properties.delete");

    Route::get("sub/product/properties/{id}", function ($id) {
        $product_properties = PropertiesProduct::find($id);
        $sub_product_properties = $product_properties->sub_properties_product;
        $id_properties = $id;
        return view("admin.products.properties.sub_propertis.index", compact('sub_product_properties', 'id_properties'));
    })->name("sub.product.properties.index");

    Route::post("sub/product/properties/{id}", function ($id, Request $request) {
        $product_properties = PropertiesProduct::find($id);
        $data_for_create_sub = [];
        $data_for_create_sub["name"] = $request->name;
        $data_for_create_sub["value"] = $request->value_properties;
        $product_properties->sub_properties_product()->create($data_for_create_sub);
        return redirect()->route("sub.product.properties.index", $id);
    })->name("sub.product.properties.store");

    Route::delete("sub/product/properties/{id}", function ($id, Request $request) {
        $propertiesProduct = SubPropertiesProduct::find($id);
        $propertiesProduct->delete();
        return redirect()->route("sub.product.properties.index", $request->id_properties);
    })->name("sub.product.properties.delete");


    Route::post("find/sub_category", function (Request $request) {
        $category = Category::find($request->id);
        $subCategories = $category->subCategories;
        return response($subCategories, 200);
    })->name("get.sub_category");

    Route::get("product/{id}/photos", function ($id) {
        $productId = $id;
        return view("admin.products.product.img", compact("productId"));
    })->name("upload.img.product");


    Route::post("product/{id}/photos/upload", function ($id, Request $request) {
        $productPhoto = new ProductPhoto();
        $file = $request->file('file');
        $name_file = $file->getClientOriginalName();
        $name_file = time() . $name_file;
        $file->move('img', $name_file);
        $productPhoto->path = $name_file;
        $productPhoto->product_id = $id;
        $productPhoto->save();
    })->name("upload.img.product.img.upload");

    Route::post("get/product/imgs", function (Request $request) {
        $product = Product::find($request->id);
        return $product->Productphotos;
    })->name("get.product.img");

    Route::post("product/img/thumbnail", function (Request $request) {
        $product_img = ProductPhoto::find($request->id);
        $product = $product_img->product;
        foreach ($product->productPhotos as $productPhoto) {
            $pig_temp = ProductPhoto::find($productPhoto->id);
            $pig_temp->thumbnail = 0;
            $pig_temp->save();
        }
        $product_img->thumbnail = 1;
        $product_img->save();
    })->name("change.thumbnail.product");

    Route::post("product/img/thumbnail/delete", function (Request $request) {
        $product_img = ProductPhoto::find($request->id);
        $product_img->delete();
    })->name("change.thumbnail.product.delete");


    //review
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
        return view("admin.products.product.review", compact("productId", "review"));
    })->name("product.review.edit");

    Route::post("product/review/change", function (Request $request) {
        $product = Product::find($request->id_product);
        if ($product->review) {
            $review = $product->review;
            $review->product_id = $request->id_product;
            $review->review = $request->text;
            $review->save();
        } else {
            $review = new Review();
            $review->product_id = $request->id_product;
            $review->review = $request->text;
            $review->save();
        }
    })->name("change.review.product");

});

Auth::routes();

//Auth::routes([
//    'register' => false, // Registration Routes...
//    'reset' => false, // Password Reset Routes...
//    'verify' => false, // Email Verification Routes...
//]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
