@extends('layouts.store')

@section('title', $product->name)

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8 text-sm text-gray-500">
        <a href="/" class="hover:text-indigo-600">خانه</a>
        <span class="mx-2">/</span>
        <a href="#" class="hover:text-indigo-600">{{ $product->subcategory->category->name }}</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">{{ $product->name }}</span>
    </nav>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Gallery -->
            <div>
                <div class="aspect-square bg-gray-50 rounded-2xl overflow-hidden mb-4 border border-gray-100">
                    <img src="https://ui-avatars.com/api/?name={{ $product->name }}&background=f3f4f6&color=6366f1&size=1024" class="w-full h-full object-cover" alt="{{ $product->name }}">
                </div>
                <div class="grid grid-cols-4 gap-4">
                    @foreach(range(1,4) as $i)
                    <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden border border-gray-100 cursor-pointer hover:border-indigo-600 transition">
                        <img src="https://ui-avatars.com/api/?name={{ $i }}&background=f3f4f6&color=6366f1" class="w-full h-full object-cover" alt="Thumb">
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <div class="mb-6">
                    <span class="text-indigo-600 font-semibold">{{ $product->brand->name }}</span>
                    <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $product->name }}</h1>
                </div>

                <div class="flex items-center mb-8">
                    <div class="flex text-yellow-400">
                        @foreach(range(1,5) as $star)
                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endforeach
                    </div>
                    <span class="text-gray-400 mr-2 text-sm">(۱۲ دیدگاه)</span>
                </div>

                <div class="mb-8">
                    <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                </div>

                <!-- Purchase Box -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-gray-500 font-semibold">قیمت:</span>
                        <span class="text-2xl font-bold text-indigo-600">{{ number_format($product->stores->first()->price_sell ?? 0) }} تومان</span>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 ml-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            موجود در انبار دانیال کالا
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 ml-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.0403 0 00-4.609 5.477 11.947 11.947 0 005.617 6.56L12 21.48l.991-.492a11.947 11.947 0 005.617-6.56 11.95 11.95 0 00-4.61-5.477z"/>
                            </svg>
                            {{ $product->stores->first()->warranty ?? 'بدون گارانتی' }}
                        </div>
                    </div>

                    <button class="w-full bg-indigo-600 text-white mt-8 py-4 rounded-xl font-bold text-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">افزودن به سبد خرید</button>
                </div>
            </div>
        </div>

        <!-- Details Tabs -->
        <div class="mt-16 border-t pt-16">
            <h2 class="text-2xl font-bold mb-8">مشخصات فنی</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-12">
                @foreach($product->properties_products as $prop)
                <div class="flex border-b border-gray-100 pb-4">
                    <span class="w-1/3 text-gray-500">{{ $prop->name }}</span>
                    <span class="w-2/3 font-semibold text-gray-900">
                        @foreach($prop->sub_properties_product as $sub)
                            {{ $sub->name }}: {{ $sub->value }}{{ !$loop->last ? '، ' : '' }}
                        @endforeach
                    </span>
                </div>
                @endforeach
                <div class="flex border-b border-gray-100 pb-4">
                    <span class="w-1/3 text-gray-500">برند</span>
                    <span class="w-2/3 font-semibold text-gray-900">{{ $product->brand->name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
