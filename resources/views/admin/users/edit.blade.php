@extends('admin.admin')
@section('title',"افزودن کاربر")
@section("title_content")
    <i class="fa fa-plus fa-fw"></i>
    افزودن کاربر
@endsection
@section("body_content")
    <div class="row">
        <div class="col-sm-3">
            <img width="100%" src="{{$user_data->photo?$user_data->photo->path:"https://placehold.co/400x400"}}" alt="">
        </div>
        <form class="col-sm-9" action="/admin/users/{{$user_data->id}}" method="post" enctype="multipart/form-data">
            @include('include.formErrors')
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <fieldset class="form-group">
                <label>نام خود را وارد کنید</label>
                <input class="form-control" name="name_user" value="{{$user_data->name}}" placeholder="نام ...">
            </fieldset>
            <fieldset class="form-group">
                <label>عکس خود را انتخاب کنید</label>
                <input class="form-control" name="img_file_user" type="file">
            </fieldset>
            <fieldset class="form-group">
                <label>پست الکترونیک خود را وارد کنید</label>
                <input class="form-control" name="email_user" value="{{$user_data->email}}" type="email"
                       placeholder="پست الکترونیک ...">
            </fieldset>
            <fieldset class="form-group">
                <label>رمزعبور قبلی را وارد کنید</label>
                <input class="form-control" type="password" name="password_user_old" placeholder="رمز ...">
            </fieldset>
            <fieldset class="form-group">
                <label>رمزعبور را وارد کنید</label>
                <input class="form-control" type="password" name="password_user" placeholder="رمز ...">
            </fieldset>
            {{--    <fieldset class="form-group">--}}
            {{--        <label>رمزعبور تایید کنید</label>--}}
            {{--        <input class="form-control" type="password" placeholder="رمز ...">--}}
            {{--    </fieldset>--}}
            <fieldset class="form-group">
                <label>مقام کاربر</label>
                <select name="select_role" class="form-control">
                    @foreach($roles as $role)
                        @if($user_data->role->id==$role->id)
                            <option value="{{$role->id}}" selected>{{$role->name}}</option>
                        @else
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endif
                    @endforeach
                </select>
            </fieldset>

            <fieldset class="form-group">
                <label>وضعیت حساب</label>
                <select name="select_status" class="form-control">
                    @switch($user_data->is_active)
                        @case(0)
                        <option value="0" selected>غیرفعال</option>
                        <option value="1">فعال</option>
                        @break
                        @case(1)
                        <option value="0">غیرفعال</option>
                        <option value="1" selected>فعال</option>
                        @break
                    @endswitch
                </select>
            </fieldset>
            {{--    <fieldset class="form-group">--}}
            {{--        <label></label>--}}
            {{--        <textarea class="form-control" rows="3"></textarea>--}}
            {{--    </fieldset>--}}
            <button type="submit" class="btn btn-secondary">افزودن کاربر</button>

            {{--    <button type="reset" class="btn btn-secondary">Reset Button</button>--}}
        </form>
        <form action="{{route('users.destroy',$user_data->id)}}" method="post">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger">حدف کاربر</button>
        </form>
    </div>
@endsection
