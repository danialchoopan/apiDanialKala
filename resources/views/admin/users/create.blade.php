@extends('admin.admin')
@section('title',"افزودن کاربر")
@section("content")
    <form action="{{route('user.store')}}" method="post" enctype="multipart/form-data">
        @csrf

        <fieldset class="form-group mb-3">
            <label>نام کامل</label>
            <input class="form-control" name="name_user" placeholder="نام ...">
        </fieldset>

        <fieldset class="form-group mb-3">
            <label>پست الکترونیک</label>
            <input class="form-control" name="email_user" type="email" placeholder="پست الکترونیک ...">
        </fieldset>

        <fieldset class="form-group mb-3">
            <label>رمزعبور</label>
            <input class="form-control" type="password" name="password_user" placeholder="رمز ...">
        </fieldset>

        <fieldset class="form-group mb-3">
            <label>مقام</label>
            <select name="select_role" class="form-control">
                <option value="0">کاربر</option>
                <option value="1">ادمین</option>
            </select>
        </fieldset>

        <div class="d-grid gap-2">
            <button class="btn btn-primary" type="submit">افزودن کاربر</button>
        </div>
    </form>

@endsection
