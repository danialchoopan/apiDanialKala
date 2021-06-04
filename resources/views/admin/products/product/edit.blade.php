@extends('admin.admin')
@section('title','بروزسانی محصول')
@section('content')

    <form action="{{route('products.update',$product->id)}}"
          method="post"
          enctype="multipart/form-data">
        @csrf
        <fieldset class="form-group  mb-3">
            <label>عنوان</label>
            <input class="form-control" name="product_title"
                   value="{{$product->name}}"
                   placeholder="عنوان را وارد کنید ..." required>
        </fieldset>

        <fieldset class="form-group  mb-3">
            <label>برند</label>
            <select name="product_brand" class="form-control" required>
                @foreach($brands as $brand)

                    @if($product->brnad_id==$brand->id)
                        <option value="{{$brand->id}}" selected>{{$brand->name}}</option>
                    @else
                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                    @endif

                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group  mb-3">
            <label>دسته بندی</label>
            <select name="product_category" id="category_parent" class="form-control" required>
                <option value="0">دسته بندی نشده !</option>
                @foreach($categories as $category)

                    @if($product->brnad_id==$brand->id)
                        <option value="{{$category->id}}" selected>{{$category->name}}</option>
                    @else
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endif

                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group  mb-3">
            <label>زیردسته</label>
            <select name="product_category_sub" id="sub_categorys" class="form-control" required>

            </select>
        </fieldset>

        <fieldset class="form-group  mb-3">
            <label>وضعیت</label>
            <select name="product_status" class="form-control" required>
                <option value="1">عرضه شده</option>
                <option value="2">به زودی</option>
                <option value="3">توقف تولید</option>
                <option value="4">آزمایشی</option>
            </select>
        </fieldset>

        <fieldset class="form-group  mb-3">
            <label>رنگ</label>
            @foreach($colors as $color)
                <label style="padding: 5px;margin: 10px"><span
                        style="background-color:{{$color->hex_code }};width: 30px;display: inline-block;height: 30px;border-radius: 50%;"></span>
                    {{$color->name}}
                    <input type="checkbox"
                           name="product_color_{{$color->id}}"
                           value="{{$color->id}}"></label>
            @endforeach
        </fieldset>

        <fieldset class="form-group mb-3">
            <label>بدنه</label>
            <textarea class="form-control" name="product_body" rows="9" required>{{$product->description}}</textarea>
        </fieldset>

        <div class="d-grid gap-2">
            <button class="btn btn-primary" type="submit">افزودن محصول</button>
        </div>

    </form>
@endsection
