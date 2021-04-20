@extends('admin.admin')
@section('title','برند ها')
@section('content')
    <div class="row">
        <div class="col-sm-3">
            <form action="{{route("brand.store")}}" method="post" enctype="multipart/form-data">
                @csrf
                <fieldset class="form-group mb-3">
                    <label>نام</label>
                    <input class="form-control" name="brand_name" placeholder="نام را وارد کنید ...">
                </fieldset>
                <fieldset class="form-group mb-3">
                    <label>لگو برند</label>
                    <input class="form-control" type="file" name="brand_logo">
                </fieldset>
                <div class="d-grid gap-2">
                    <input type="submit" value="افزودن برند" class="btn btn-primary">
                </div>
            </form>
        </div>
        <div class="col-sm-9">
            @if(count($brands)>0)
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>لوگو</th>
                        <th>ساخته شده در</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($brands as $brand)
                        <tr>
                            <td>{{$brand->id}}</td>
                            <td><a href="{{route('brand.show',$brand->id)}}">{{$brand->name}}</a></td>
                            <td><img
                                    width="100"
                                    src="{{env('DEFAULT_URL','')}}storage/{{$brand->photo->path}}"></td>
                            <td>{{$brand->created_at->diffForHumans()}}</td>
                            <td>
                                <form action="{{route('brand.destroy',$brand->id)}}" method="post">
                                    @csrf
                                    @method("delete")
                                    <input type="submit" class="btn btn-danger" value="حذف">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>برندی برای نمایش وجود نداره :-(</p>
            @endif
        </div>
    </div>
@endsection
