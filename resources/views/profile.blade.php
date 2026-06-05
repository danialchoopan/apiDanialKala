@extends('layouts.store')

@section('title', 'پنل کاربری')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row gap-12">
        <!-- Sidebar -->
        <aside class="w-full md:w-80 flex-shrink-0">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="flex items-center gap-4 mb-10 pb-6 border-b">
                    <div class="h-16 w-16 rounded-full bg-indigo-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ mb_substr(auth()->user()->name ?? 'ک', 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-900">{{ auth()->user()->name ?? 'کاربر مهمان' }}</h3>
                        <p class="text-gray-500 text-sm">{{ auth()->user()->phone ?? '---' }}</p>
                    </div>
                </div>

                <nav class="space-y-2">
                    <a href="/profile" class="flex items-center gap-4 py-3 px-4 rounded-xl bg-indigo-50 text-indigo-600 font-bold">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 118 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        سفارشات من
                    </a>
                    <a href="#" class="flex items-center gap-4 py-3 px-4 rounded-xl text-gray-600 hover:bg-gray-50 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        علاقه‌مندی‌ها
                    </a>
                    <a href="#" class="flex items-center gap-4 py-3 px-4 rounded-xl text-gray-600 hover:bg-gray-50 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        آدرس‌ها
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-4 py-3 px-4 rounded-xl text-red-500 hover:bg-red-50 transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            خروج از حساب
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h3 class="font-bold text-xl mb-8">سفارشات اخیر</h3>

                <div class="space-y-6">
                    @forelse(App\Models\Order::where('user_id', auth()->id())->latest()->get() as $order)
                    <div class="border rounded-2xl p-6">
                        <div class="flex flex-wrap justify-between items-center gap-4 mb-6 border-b pb-4">
                            <div class="flex gap-6 flex-wrap">
                                <div>
                                    <span class="text-gray-400 text-xs block mb-1">کد سفارش</span>
                                    <span class="font-bold text-gray-900">#{{ $order->order_product_id }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-xs block mb-1">تاریخ</span>
                                    <span class="font-bold text-gray-900">{{ $order->created_at }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-xs block mb-1">مبلغ کل</span>
                                    <span class="font-bold text-gray-900">{{ number_format($order->price) }} تومان</span>
                                </div>
                            </div>
                            <span class="px-4 py-1 rounded-full text-sm font-bold {{ $order->status == 100 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $order->status == 100 ? 'پرداخت شده' : 'در انتظار پرداخت' }}
                            </span>
                        </div>
                        <div class="flex gap-4">
                            <!-- Order item thumbs simulation -->
                            <div class="h-16 w-16 bg-gray-50 rounded-xl border p-1">
                                <img src="https://ui-avatars.com/api/?name=P&background=random" class="h-full w-full object-cover rounded-lg" alt="">
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <p class="text-gray-500">هنوز هیچ سفارشی ثبت نکرده‌اید.</p>
                        <a href="/shop" class="text-indigo-600 font-bold mt-4 inline-block hover:underline">مشاهده فروشگاه</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
