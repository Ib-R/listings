@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>{{$post->title}}</h1>
            <img style="width:100%;" src="/storage/cover_imgs/{{$post->cover_img}}" alt="Cover Image">
        </div>
        <div class="panel-body">
            <p>{!!$post->body!!}</p>
        </div>
    </div>
    <small>Created on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>

            {!!Form::open(['action'=>['PostsController@destroy',$post->id],'method'=>'POST','class'=>'pull-right','onsubmit'=>'return confirm("Are You Sure?")'])!!}
                {{Form::hidden('_method','DELETE')}}
                {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
@endsection