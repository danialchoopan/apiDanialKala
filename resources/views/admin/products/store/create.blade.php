@extends('admin.admin')
@section('title','افزودن انبار داری محصول')
@section('content')

    <form action="{{route("store.store",$id_product)}}" method="post">
        @csrf
        <fieldset class="form-group mb-3">
            <label>تعداد</label>
            <input class="form-control" name="store_number" placeholder="تعداد را وارد کنید">
        </fieldset>
        <fieldset class="form-group mb-3">
            <label>گارانتی</label>
            <input class="form-control" name="store_warranty" placeholder="گارانتی را وارد کنید ...">
        </fieldset>

        <fieldset class="form-group mb-3">
            <label>رنگ</label>
            @foreach($colors as $color)
                <label style="padding: 5px;margin: 10px"><span
                        style="background-color:{{$color->hex_code }};width: 30px;display: inline-block;height: 30px;border-radius: 50%;"></span>
                    {{$color->name}}
                    <input type="radio" name="product_color" value="{{$color->id}}"></label>
            @endforeach
        </fieldset>

        <fieldset class="form-group mb-3">
            <label>قیمت خرید</label>
            <input class="form-control" name="store_price_buy" placeholder="گارانتی را وارد کنید ...">
        </fieldset>

        <fieldset class="form-group mb-3">
            <label>فیمت فروش</label>
            <input class="form-control" name="store_price_sell" placeholder="گارانتی را وارد کنید ...">
        </fieldset>

        <input type="submit" value="افزودن انبار داری محصول" class="btn btn-primary">
    </form>
@endsection
