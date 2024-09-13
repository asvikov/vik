@extends('layout')
@section('title') VIK @stop
@section('main_body')
    <div class="container mt-3">
        @foreach($articles as $article)
            <div class="row mb-4 news-block">
                <div class="col-lg-3 col-md-4 mb-2">
                    <img src="{{$article->image_url}}" class="w-100">
                </div>
                <div class="col-lg-9 col-md-8">
                    <div><h2>{{$article->title}}</h2></div>
                    <div class="news-block-text">{{$article->description}}</div>
                    <a href="/articles/{{$article->id}}">Подробнее...</a>
                </div>
            </div>
        @endforeach
    </div>
@stop
