@extends('admin.admin')
@section('title','اسلایدر')
@section('content')
    <div class="table-responsive">
        @if(count($sliders)>0)
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>تصویر</th>
                    <th>عنوان</th>
                    <th>ساخته شده در</th>
                    <th>بروزرسانی شده در</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($sliders as $slider)
                    <tr>
                        <td>{{$slider->id}}</td>
                        <td><img src="{{env('DEFAULT_URL','')}}storage/{{$slider->photo->path}}"
                                 width="100"></td>
                        <td><a href="{{route('slider.edit',$slider->id)}}">{{$slider->title}}</a></td>
                        <td>{{$slider->created_at->diffForHumans()}}</td>
                        <td>{{$slider->updated_at->diffForHumans()}}</td>
                        <td>
                            <form action="{{route('slider.destroy',$slider->id)}}" method="post">
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
            <p>نوشته ای برای نمایش وجود ندارد :-(</p>
        @endif
    </div>
@endsection
