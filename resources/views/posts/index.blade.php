@extends('layouts.app')

@section('content')
    <h1>Posts Page</h1>
    <div class="panel-group">
        @if(count($posts) > 0)
            @foreach($posts as $post)
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <img style="width:100%;max-height:300px" src="{{url('/storage/cover_imgs/'.$post->cover_img)}}" alt="Cover Image">
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <h1><a href="{{url('/posts/'.$post->id)}}">{{$post->title}}</a></h1>
                            <p>{!!$post->body!!}</p>
                            <small>Created on {{$post->created_at}} by {{$post->user->name}}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            No Posts Found
        @endif
    </div>
@endsection