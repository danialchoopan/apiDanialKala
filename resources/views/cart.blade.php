@extends('layouts.store')

@section('title', 'سبد خرید')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-10">سبد خرید شما</h1>

    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Cart Items -->
        <div class="flex-1 space-y-6">
            @php $cartItems = App\Models\Product::take(2)->get(); @endphp
            @foreach($cartItems as $item)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center gap-6">
                <img src="https://ui-avatars.com/api/?name={{ $item->name }}&background=f3f4f6&color=6366f1" class="h-24 w-24 rounded-2xl object-cover" alt="">
                <div class="flex-1">
                    <h3 class="font-bold text-lg text-gray-900">{{ $item->name }}</h3>
                    <p class="text-gray-500 text-sm mt-1">گارانتی ۱۸ ماهه پارسه</p>
                    <div class="mt-4 flex items-center gap-4">
                        <div class="flex items-center border rounded-lg overflow-hidden">
                            <button class="px-3 py-1 bg-gray-50 hover:bg-gray-100">-</button>
                            <span class="px-4 py-1 font-bold">۱</span>
                            <button class="px-3 py-1 bg-gray-50 hover:bg-gray-100">+</button>
                        </div>
                        <button class="text-red-500 hover:text-red-700 text-sm font-semibold">حذف</button>
                    </div>
                </div>
                <div class="text-left">
                    <div class="text-xl font-bold text-indigo-600">{{ number_format($item->stores->first()->price_sell ?? 0) }} تومان</div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Summary -->
        <aside class="w-full lg:w-96 flex-shrink-0">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 sticky top-32">
                <h3 class="font-bold text-xl mb-8">خلاصه سفارش</h3>

                <div class="space-y-4 mb-8 border-b pb-8">
                    <div class="flex justify-between text-gray-600">
                        <span>قیمت کالاها (۲)</span>
                        <span>۱۵,۵۰۰,۰۰۰ تومان</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>هزینه ارسال</span>
                        <span class="text-green-500 font-semibold">رایگان</span>
                    </div>
                </div>

                <div class="flex justify-between text-xl font-bold mb-8">
                    <span>جمع کل</span>
                    <span class="text-indigo-600">۱۵,۵۰۰,۰۰۰ تومان</span>
                </div>

                <a href="/checkout" class="block w-full bg-indigo-600 text-white py-4 rounded-xl font-bold text-center hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">ادامه فرآیند خرید</a>
            </div>
        </aside>
    </div>
</div>
@endsection
