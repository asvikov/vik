@extends('layout')
@section('title')
    login
@stop
@section('main_body')
    <div class="container">
        <div class="row g-3 align-items-center">
            <form name="login_form" method="POST" action="{{url('login')}}">
                @csrf
                <div class="col-auto">
                    <label for="email" class="col-form-label">Email</label>
                </div>
                <div class="col-auto">
                    <input type="text" name="email" class="col-form-control" value="{{old('email')}}">
                </div>
                <div class="col-auto">
                    <label for="password" class="col-form-label">Пароль</label>
                </div>
                <div class="col-auto mb-3">
                    <input type="password" name="password" class="col-form-control" value="{{old('password')}}">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember_user" class="form-check-input">
                    <label for="remember_user" class="form-check-label">запомнить меня</label>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" value="войти">
                </div>
            </form>
            @include('errors/list')
        </div>
    </div>
@stop
