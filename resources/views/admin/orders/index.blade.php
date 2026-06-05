@extends('layouts.admin_tailwind')

@section('title', 'مدیریت سفارشات')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h4 class="text-lg font-semibold text-gray-800">لیست سفارشات</h4>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-right">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">شماره سفارش</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">کاربر</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">مبلغ کل</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">تاریخ</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->order_product_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->user->name ?? 'کاربر مهمان' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($order->price) }} تومان</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status == 100 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $order->status == 100 ? 'پرداخت شده' : 'در انتظار' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('orders.show', $order->order_product_id) }}" class="text-indigo-600 hover:text-indigo-900">جزئیات</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 bg-gray-50">
        {{ $orders->links() }}
    </div>
</div>
@endsection
