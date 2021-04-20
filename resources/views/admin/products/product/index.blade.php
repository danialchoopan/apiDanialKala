@extends("admin.admin")
@section('title','محصولات ')
@section("content")
    <div class="table-responsive">
        @if(count($products)>0)
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان</th>
                    <th>عکس</th>
                    <th>دسته بندی</th>
                    <th>برند</th>
                    <th>توضیحات</th>
                    <th>ساخته شده در</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td><a href="{{route('products.edit',$product->id)}}">{{$product->name}}</a></td>
                        <td>
                            {{count($product->Productphotos) ? "" : "عکسی وجود ندارد"}}
                            @foreach($product->Productphotos as $photo)
                                @if($photo->thumbnail==1)
                                    <img style="width: 200px;"
                                         src="{{env('DEFAULT_URL','')}}img/{{$photo->path}}" alt="">
                                @endif
                            @endforeach
                        </td>
                        <td>{{$product->subcategory->name}}</td>
                        <td>{{$product->brand->name}}</td>
                        <td>{{substr($product->description,0,10)}} ...</td>
                        <td>{{$product->created_at->diffForHumans()}}</td>
                        <td>
                            <a class="btn btn-success m-1" href="{{route('upload.img.product',$product->id)}}">افزودن عکس</a>
                            <a class="btn btn-success m-1" href="{{route('product.review.edit',$product->id)}}">افزودن
                                نقد</a>
                            <br>
                            <a class="btn btn-success m-1" href="{{route('product.properties.index',$product->id)}}">افزودن
                                مشحصات</a>
                            <a class="btn btn-success m-1" href="{{route('store.index',$product->id)}}">
                                انبار داری</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>محصول ای برای نمایش وجود ندارد :-(</p>
        @endif
    </div>
@endsection
