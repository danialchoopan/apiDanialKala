@extends("admin.admin")
@section('title','زیر مشخصات')
@section('title_content')
    <i class="fa fa-pause fa-fw"></i>
    زیر مشخصات
@endsection
@section("body_content")
    {{--    @include('include.messageAlertSessions')--}}
    <div class="table-responsive">
        <div class="col-sm-3">
            <form action="{{route('sub.product.properties.store',$id_properties)}}" method="post">
                {{--                @include("include.formErrors")--}}
                @csrf
                @method("post")
                <fieldset class="form-group">
                    <label>نام</label>
                    <input class="form-control" name="name" placeholder="نام را وارد کنید ...">
                    <br>
                    <input class="form-control" name="value_properties" placeholder="مقدار را وارد کنید ...">
                    <br>
                </fieldset>
                <input type="submit" value="افزودن مشخصات" class="btn btn-primary">
            </form>
        </div>
        <div class="col-sm-9">
            @if(count($sub_product_properties)>0)
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>مقدار</th>
                        <th>ساخته شده در</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sub_product_properties as $proper)
                        <tr>
                            <td>{{$proper->id}}</td>
                            <td><a href="{{route("sub.product.properties.index",$proper->id)}}">{{$proper->name}}</a>
                            </td>
                            <td>{{$proper->value}}</td>
                            <td>{{$proper->created_at->diffForHumans()}}</td>
                            <td>
                                <form action="{{route("sub.product.properties.delete",$proper->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="id_properties" value="{{$id_properties}}">
                                    <input type="submit" class="btn btn-danger" value="حذف">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>زیر مشحصاتی برای نمایش وجود ندارد ای برای نمایش وجود ندارد :-(</p>
            @endif
        </div>
    </div>
@endsection
