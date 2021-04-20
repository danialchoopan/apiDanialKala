@extends('admin.admin')
@section('title',' بروزرسانی برند')
@section('content')
    <div class="col-sm-3">
        <img width="99%" src="{{$brand->photo ? $brand->photo->path:"https://placehold.co/400x400"}}" alt="">
    </div>
    <form action="{{route("brand.update",$brand->id)}}" class="col-sm-9" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <fieldset class="form-group mb-3">
            <label>نام</label>
            <input class="form-control" name="brand_name" placeholder="نام را وارد کنید ..." value="{{$brand->name}}">
        </fieldset>

        <fieldset class="form-group mb-3">
            <label>عکس</label>
            <input type="file" name="brand_logo" class="form-control">
        </fieldset>
        <div class="d-grid gap-2 mb-3">
            <input type="submit" value="بروزرسانی برند" class="btn btn-primary">
        </div>

    </form>
    <div style="clear: both"></div>
@endsection
