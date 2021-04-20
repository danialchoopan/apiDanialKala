<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0;$i<=10;$i++) {
            $category = new Category();
            $category->name = "درسته بندی".rand(0,100);
            $category->name_en = Str::random(10);
            $category->save();
        }
    }
}
