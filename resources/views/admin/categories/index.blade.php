@extends('admin.admin')
@section('title','دسته بندی محصولات')
@section('content')
    <div class="row">
        <div class="col-sm-3">
            <form action="{{route("category.store")}}" method="post" enctype="multipart/form-data">
                @csrf
                <fieldset class="form-group mb-3">
                    <label>نام</label>
                    <input class="form-control" name="category_name" placeholder="نام را وارد کنید ...">
                </fieldset>
                <fieldset class="form-group mb-3">
                    <label>عکس</label>
                    <input class="form-control" type="file" name="category_photo" placeholder="عکس را وارد کنید ...">
                </fieldset>
                <div class="d-grid gap-2">
                    <input type="submit" value="افزودن دسته بندی" class="btn btn-primary">
                </div>
            </form>
        </div>
        <div class="col-sm-9">
            @if(count($categories)>0)
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>عکس</th>
                        <th>ساخته شده در</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td><a href="{{route('category.show',$category->id)}}">{{$category->name}}</a></td>
                            <td>
                                <img
                                    width="100"
                                    src="{{env('DEFAULT_URL','')}}storage/{{$category->photo->path }}"
                                    alt="">
                            </td>
                            <td>{{$category->created_at->diffForHumans()}}</td>
                            <td>
                                <form action="{{route('category.destroy',$category->id)}}" method="post">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="submit" class="btn btn-danger" value="حذف">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>دسته بندی ای برای نمایش وجود ندارد :-(</p>
            @endif
        </div>
    </div>
@endsection
