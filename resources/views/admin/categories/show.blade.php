@extends('admin.admin')
@section('title')
    {{$category->name}} زیر دسته
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-3">
            <form action="{{route("sub_category.store")}}" method="post" enctype="multipart/form-data">
                @csrf
                <fieldset class="form-group mb-3">
                    <label>نام</label>
                    <input class="form-control" name="sub_category_name" placeholder="نام را وارد کنید ...">
                </fieldset>

                <fieldset class="form-group mb-3">
                    <label>عکس</label>
                    <input type="file"
                           class="form-control"
                           name="sub_category_photo">
                </fieldset>

                <input type="hidden" name="sub_category_id" value="{{$category->id}}">

                <div class="d-grid gap-2">
                    <input type="submit" value=" افزودن زیردسته {{ $category->name }}" class="btn btn-primary">
                </div>
            </form>
        </div>
        <div class="col-sm-9">
            @if(count($subCategories)>0)
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
                    @foreach($subCategories as $subCategory)
                        <tr>
                            <td>{{$subCategory->id}}</td>
                            <td><a href="{{route('sub_category.edit',$subCategory->id)}}">{{$subCategory->name}}</a>
                            </td>
                            <td>
                                <img
                                    width="100"
                                    src="{{env('DEFAULT_URL','')}}storage/{{$subCategory->photo->path}}" alt="">
                            </td>
                            <td>{{$subCategory->created_at->diffForHumans()}}</td>
                            <td>
                                <form action="{{route('sub_category.destroy',$subCategory->id)}}" method="post">
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
                <p>دسته بندی ای برای نمایش وجود ندارد :-(</p>
            @endif
        </div>
    </div>

@endsection
