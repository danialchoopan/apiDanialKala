<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Photo;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\Slider;
use App\Models\Store;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        User::create([
            'name' => 'مدیر سیستم',
            'email' => 'admin@danialkala.com',
            'password' => Hash::make('password'),
            'role' => 1,
            'phone' => '09123456789'
        ]);

        // Regular User
        User::create([
            'name' => 'کاربر نمونه',
            'email' => 'user@danialkala.com',
            'password' => Hash::make('password'),
            'role' => 0,
            'phone' => '09123456788'
        ]);

        // Colors
        $colors = [
            ['name' => 'مشکی', 'hex_code' => '#000000'],
            ['name' => 'سفید', 'hex_code' => '#FFFFFF'],
            ['name' => 'قرمز', 'hex_code' => '#FF0000'],
            ['name' => 'آبی', 'hex_code' => '#0000FF'],
            ['name' => 'طلایی', 'hex_code' => '#FFD700'],
        ];
        foreach ($colors as $c) {
            Color::create($c);
        }

        // Brands
        $brands = ['سامسونگ', 'اپل', 'شیائومی', 'هواوی', 'سونی'];
        foreach ($brands as $b) {
            $brandPhoto = Photo::create(['path' => 'brand_placeholder.png']);
            Brand::create([
                'name' => $b,
                'photo_id' => $brandPhoto->id
            ]);
        }

        // Categories & SubCategories
        $categories = [
            'کالای دیجیتال' => ['موبایل', 'لپ تاپ', 'تبلت'],
            'مد و پوشاک' => ['مردانه', 'زنانه', 'بچگانه'],
            'خانه و آشپزخانه' => ['صوتی و تصویری', 'لوازم برقی'],
        ];

        foreach ($categories as $catName => $subs) {
            $photo = Photo::create(['path' => 'cat_placeholder.png']);
            $category = Category::create([
                'name' => $catName,
                'photo_id' => $photo->id
            ]);

            foreach ($subs as $subName) {
                $subPhoto = Photo::create(['path' => 'subcat_placeholder.png']);
                SubCategory::create([
                    'name' => $subName,
                    'category_id' => $category->id,
                    'photo_id' => $subPhoto->id
                ]);
            }
        }

        // Products
        $subCategories = SubCategory::all();
        $brandsList = Brand::all();
        $colorsList = Color::all();

        for ($i = 1; $i <= 20; $i++) {
            $product = Product::create([
                'name' => 'محصول نمونه ' . $i,
                'description' => 'توضیحات کوتاه برای محصول نمونه ' . $i,
                'subCategory_id' => $subCategories->random()->id,
                'brand_id' => $brandsList->random()->id,
                'status' => 1,
                'colors' => serialize([$colorsList->random()->id, $colorsList->random()->id]),
            ]);

            // Product Photo
            ProductPhoto::create([
                'product_id' => $product->id,
                'path' => 'product_placeholder.png',
                'thumbnail' => 1
            ]);

            // Store / Price
            Store::create([
                'product_id' => $product->id,
                'color_id' => $colorsList->random()->id,
                'count' => rand(10, 100),
                'warranty' => 'گارانتی ۱۸ ماهه پارسه',
                'price_buy' => (string)rand(1000000, 5000000),
                'price_sell' => (string)rand(6000000, 10000000),
            ]);

            // Review
            $product->review()->create([
                'review' => 'نقد و بررسی تخصصی محصول نمونه ' . $i . ' که شامل جزئیات فنی و کاربردی است.'
            ]);
        }

        // Sliders
        for ($i = 1; $i <= 3; $i++) {
            $photo = Photo::create(['path' => 'slider_' . $i . '.png']);
            Slider::create([
                'photo_id' => $photo->id,
                'title' => 'اسلایدر شماره ' . $i
            ]);
        }
    }
}
