@extends('layouts.store')

@section('title', 'فروشگاه')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-bold text-lg mb-6 border-b pb-4">فیلترها</h3>

                <div class="mb-8">
                    <h4 class="font-semibold mb-4">دسته‌بندی</h4>
                    <ul class="space-y-2">
                        @foreach(App\Models\Category::all() as $cat)
                        <li>
                            <label class="flex items-center text-gray-600 hover:text-indigo-600 cursor-pointer">
                                <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 ml-2">
                                {{ $cat->name }}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mb-8">
                    <h4 class="font-semibold mb-4">برند</h4>
                    <ul class="space-y-2">
                        @foreach(App\Models\Brand::all() as $brand)
                        <li>
                            <label class="flex items-center text-gray-600 hover:text-indigo-600 cursor-pointer">
                                <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 ml-2">
                                {{ $brand->name }}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <button class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">اعمال فیلتر</button>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="flex-1">
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <span class="text-gray-500">نمایش {{ $products->count() }} محصول</span>
                <div class="flex items-center gap-4">
                    <label class="text-gray-500 whitespace-nowrap">مرتب‌سازی:</label>
                    <select class="bg-gray-50 border-gray-200 rounded-lg py-1 pr-8 focus:ring-indigo-500">
                        <option>جدیدترین</option>
                        <option>ارزان‌ترین</option>
                        <option>گران‌ترین</option>
                        <option>پرفروش‌ترین</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-300">
                    <a href="{{ route('product.show', $product->id) }}" class="block p-4">
                        <img src="https://ui-avatars.com/api/?name={{ $product->name }}&background=f3f4f6&color=6366f1&size=512" class="w-full aspect-square object-cover rounded-xl mb-4" alt="{{ $product->name }}">
                        <h3 class="font-bold text-gray-800 mb-2 truncate">{{ $product->name }}</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-sm">{{ $product->subcategory->name }}</span>
                            <div class="text-indigo-600 font-bold">
                                {{ number_format($product->stores->first()->price_sell ?? 0) }} تومان
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
