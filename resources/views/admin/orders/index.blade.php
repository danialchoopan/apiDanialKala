@extends('admin.admin')
@section('title','سفارش ها')
@section('content')
    @if(count($orders)>0)
      <a href="{{route('orders.index')}}" class="btn btn-primary">همه</a>
      <a href="{{route('status.order',100)}}" class="btn btn-success">تایید شده ها </a>
      <a href="{{route('status.order',1)}}" class="btn btn-danger">ناموفق ها</a>

        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>شماره سفارش</th>
                <th>وضغیت</th>
                <th>کاربر</th>
                <th>قیمت</th>
                <th>ساخته شده در</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->order_product_id}}</td>
                    @if($order->status==100)
                        <td style="background-color:green;color:white">{{ "پرداخت موفق" }}</td>
                    @else
                        <td style="background-color:red;color:white">{{ "پرداخت ناموفق" }}</td>
                    @endif
                    <td>{{ App\Models\User::find($order->user_id)->name }}</td>
                    <td>{{ number_format($order->price) . " تومان"}}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        <a href="{{route('orders.show',$order->order_product_id)}}" class="btn btn-primary">جزئیات</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>سفارشی برای نمایش وجود ندارد ای برای نمایش وجود ندارد :-(</p>
    @endif
@endsection
