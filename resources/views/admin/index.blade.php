@extends('layouts.admin_tailwind')

@section('title', 'داشبورد مدیریت')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-50 text-indigo-600">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 118 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div class="mr-4 text-right">
                <p class="text-gray-500 text-sm">کل فروش</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format(App\Models\Order::where('status', 100)->sum('price')) }} تومان</p>
            </div>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-50 text-green-600">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <div class="mr-4 text-right">
                <p class="text-gray-500 text-sm">سفارشات جدید</p>
                <p class="text-2xl font-bold text-gray-800">{{ App\Models\Order::where('status', 0)->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="mr-4 text-right">
                <p class="text-gray-500 text-sm">تعداد محصولات</p>
                <p class="text-2xl font-bold text-gray-800">{{ App\Models\Product::count() }}</p>
            </div>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-50 text-yellow-600">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div class="mr-4 text-right">
                <p class="text-gray-500 text-sm">کاربران</p>
                <p class="text-2xl font-bold text-gray-800">{{ App\Models\User::count() }}</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h4 class="text-lg font-semibold text-gray-800">سفارشات اخیر</h4>
            <a href="{{ route('orders.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">مشاهده همه</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">شماره سفارش</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">مبلغ</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse(App\Models\Order::latest()->take(5)->get() as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">#{{ $order->order_product_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($order->price) }} تومان</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $order->status == 100 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $order->status == 100 ? 'پرداخت شده' : 'در انتظار' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">سفارشی یافت نشد.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inventory Status -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h4 class="text-lg font-semibold text-gray-800">وضعیت موجودی انبار</h4>
            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">کمبود موجودی</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">محصول</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">تعداد</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach(App\Models\Store::where('count', '<', 20)->take(5)->get() as $store)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $store->product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $store->count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-full bg-gray-200 rounded-full h-1.5 max-w-[100px]">
                                <div class="bg-red-500 h-1.5 rounded-full" style="width: {{ ($store->count / 20) * 100 }}%"></div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
