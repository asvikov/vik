@extends('layout')
@section('title') {{$article->title}} @stop
@section('description') {{$article->description}} @stop
@section('main_body')
    <div class="container mt-3">
        <div class="mb-3"><h1>{{$article->title}}</h1></div>
        <div>{!!$article->content!!}</div>
    </div>
@stop
