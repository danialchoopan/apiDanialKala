@extends("admin.admin")
@section('title','پست ها')
@section('title_content')
    <i class="fa fa-comments fa-fw"></i>
    پست ها
@endsection
@section("body_content")
    @include('include.messageAlertSessions')
    <div class="table-responsive">
        @if(count($posts)>0)
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>تصویر</th>
                    <th>عنوان</th>
                    <th>بدنه</th>
                    <th>دسته بندی</th>
                    <th>کاربر</th>
                    <th>ساخته شده در</th>
                    <th>بروزرسانی شده در</th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{$post->id}}</td>
                        <td><img src="{{$post->photo ? $post->photo->path : "https://placehold.co/400x400"}}" height="50"></td>
                        <td><a href="{{route('posts.edit',$post->id)}}">{{$post->title}}</a></td>
                        <td>{{substr($post->body,0,10)}} ...</td>
                        <td>{{$post->category ? $post->category->name : "دسته بندی نشده !"}}</td>
                        <td>{{$post->user->name}}</td>
                        <td>{{$post->created_at->diffForHumans()}}</td>
                        <td>{{$post->updated_at->diffForHumans()}}</td>
                        <td><a href="{{route('comments.show',$post->id)}}">({{$count_comments}})نظرات</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-5">
                    {{$posts->render()}}
                </div>
            </div>
        @else
            <p>نوشته ای برای نمایش وجود ندارد :-(</p>
        @endif
    </div>
@endsection
