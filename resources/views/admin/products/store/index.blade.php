@extends('admin.admin')
@section('title','انبار داری')
@section('content')

    <a href="{{route('store.create',$id_product)}}" class="btn btn-success" style="margin: 10px">افزودن</a>
    @if(count($stores)>0)
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>محصول</th>
                <th>رنگ</th>
                <th>تعداد</th>
                <th>گارانتی</th>
                <th>قیمت خرید</th>
                <th>قیمت فروش</th>
                <th>ساخته شده در</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stores as $store)
                <tr>
                    <td>{{ $store->id }}</td>
                    <td>{{ $store->product->name }}</td>
                    <td style="background-color:{{ \App\Models\Color::find($store->color_id)->hex_code }} "></td>
                    <td>{{ $store->count }}</td>
                    <td>{{ $store->warranty }}</td>
                    <td>{{ $store->price_buy }}</td>
                    <td>{{ $store->price_sell }}</td>
                    <td>{{ $store->created_at }}</td>
                    <td>
                        <form action="{{route('store.delete',$store->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <input type="submit" class="btn btn-danger" value="حذف">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>انباری برای نمایش وجود ندارد ای برای نمایش وجود ندارد :-(</p>
    @endif
@endsection
