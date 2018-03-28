@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>Welcome to {{config('app.name')}}</h1>
        <p>This is my laravel application</p>
        <a href="/login" class="btn btn-primary btn-lg" role="button">Login</a>
        <a href="/register" class="btn btn-success btn-lg" role="button">Register</a>
    </div>
@endsection