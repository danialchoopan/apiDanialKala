@extends('admin.admin')
@section("title","کاربران")
@section("content")
    <div class="table-responsive">
        @if(count($users)>0)
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>پست الکترونیک</th>
                    <th>مقام</th>
                    <th>ساخته شده در</th>
                    <th>بروزرسانی شده در</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td><?php echo $user->role ? "ادمین" : "کاربر" ?></td>
                        <td>{{$user->created_at->diffForHumans()}}</td>
                        <td>{{$user->updated_at->diffForHumans()}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
