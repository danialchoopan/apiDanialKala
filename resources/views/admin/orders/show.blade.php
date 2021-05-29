@extends('admin.admin')
@section('title','محصولات سفازش')
@section('content')
    @if(count($productOrders)>0)
        <p class="m-2">نمایش تمامی محصولات این سفارش</p>

        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>نام</th>
                <th>عکس</th>
                <th>دسته بندی</th>
                <th>زیر دسته بندی</th>
                <th>قیمت</th>
                <th>ساخته شده در</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($productOrders as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name}}</td>
                    <td>
                        <img style="width: 200px;"
                             src="{{env('APP_URL')}}{{$product->thumbnail}}" alt="">
                    </td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->Subcategory }}</td>
                    <td>{{ number_format($product->price) . " تومان"}}</td>
                    <td>{{ $product->created_at }}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>سفارشی برای نمایش وجود ندارد ای برای نمایش وجود ندارد :-(</p>
    @endif
@endsection
