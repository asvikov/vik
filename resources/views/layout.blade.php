<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/app.css" rel="stylesheet">
    <title>@yield('title')</title>
    <meta content="@yield('description')" name="description">
</head>
<body>
@include('partials/navbar')
@yield('main_body')

<script type="text/javascript" src="/js/app.js"></script>
<script src="/js/tinymce/tinymce.min.js"></script>

@yield('script')
</body>
</html>
