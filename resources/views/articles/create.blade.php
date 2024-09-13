@extends('layout')
@section('title') создать новость @stop
@section('main_body')
    <div class="container py-3">
        <form action="{{$action}}" method="POST" enctype="multipart/form-data">
            @isset($method)
                @method($method)
            @endisset
            @csrf
            <div class="form-group mb-3">
                <label for="title">Заголовок (макс. 255 симв.)</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="title" value="{{$article->title ? $article->title : old('title')}}">
            </div>
            <div class="form-group mb-3">
                <label for="description">Краткое описание (макс. 255 симв.)</label>
                <input type="text" name="description" class="form-control" id="description" placeholder="description" value="{{$article->description ? $article->description : old('description')}}">
            </div>
            <div class="custom-file mb-3">
                <label for="logo_url" class="custom-file-label">Изображение анонса</label>
                <img src="{{asset($article->image_url ? $article->image_url : 'storage/images/articles/blank_l.jpg')}}" class="d-md-block img-thumbnail art-img mb-2 js-img">
                <input type="file" accept="image" name="image" class="form-control custom-file-input js-image-input">
            </div>
            <div class="mb-3">
                <textarea id="content" name="content" placeholder="Основной текст новости">{{$article->content ? $article->content : old('content')}}</textarea>
            </div>
            <div class="float-end mb-3">
                <button type="submit" id="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{url('/articles')}}" class="btn btn-primary">Отменить</a>
            </div>
        </form>
        @include('errors/list')
    </div>
@stop
@section('script')
    <script>
        tinymce.init({
            selector: 'textarea#content',
            language: 'ru'
        });

        $('.js-image-input').change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.js-img').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@stop
