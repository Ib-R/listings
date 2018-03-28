@extends('layouts.app')

@section('content')
    <h1>Make a post!</h1>

    {!! Form::open(['action' => 'PostsController@store', 'enctype'=>'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Post Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder'=>'The Title'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Post Body')}}
            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control','placeholder'=>'Write the post here'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_img',['class'=>'btn btn-primary'])}}
        </div>
        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}

    {!! Form::close() !!}

@endsection