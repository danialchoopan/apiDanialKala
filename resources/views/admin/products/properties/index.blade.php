@extends("admin.admin")
@section('title','مشخصات')
@section("content")
    {{--    @include('include.messageAlertSessions')--}}
    <div class="row">
        <div class="col-sm-2">
            <form action="{{route("product.properties.store",$id)}}" method="post">
                {{--                @include("include.formErrors")--}}
                @csrf
                @method("post")
                <fieldset class="form-group">
                    <label>نام</label>
                    <input class="form-control" name="name" placeholder="نام را وارد کنید ..." required>
                    <br>
                </fieldset>
                <input type="submit" value="افزودن مشخصات" class="btn btn-primary">
            </form>
        </div>
        <div class="col-sm-9">
            @if(count($properties))
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>ساخته شده در</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($properties as $proper)
                        <tr>
                            <td>{{$proper->id}}</td>
                            <td><a href="{{route("sub.product.properties.index",$proper->id)}}">{{$proper->name}}</a>
                            </td>
                            <td>{{$proper->created_at->diffForHumans()}}</td>
                            <td>
                                <form action="{{route("product.properties.delete",$proper->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="id_product" value="{{$id}}">
                                    <input type="submit" class="btn btn-danger" value="حذف">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>مشحصاتی برای نمایش وجود ندارد ای برای نمایش وجود ندارد :-(</p>
            @endif
        </div>
    </div>
@endsection
