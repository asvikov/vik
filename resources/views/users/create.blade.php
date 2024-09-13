@extends('layout')
@section('title')создать пользователя@stop
@section('main_body')
    <div class="container px-1">
    <div class="my-sm-3 initialism">создать нового пользователя</div>
        @include('users/create_edit_form', ['action' => route('users.store'), 'method' => 'POST'])
        @include('errors/list')
    </div>
@stop
@section('script')
    <script>
        $(document).ready(function () {

            $('#create_user_form').validate({
                rules: {
                    name: 'required',
                    lastname: 'required',
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        equalTo: '#password_confirmation'
                    },
                    'roles[]': 'required'
                },
                messages: {
                    name: 'введите имя',
                    lastname: 'введите фамилию',
                    email: {
                        required: 'введите e-mail',
                        email: 'адрес должен быть вида name@domain.com'
                    },
                    password: {
                        required: 'введите корректный пароль',
                        equalTo: 'пароль должен совподать с полем подтверждения'
                    },
                    'roles[]': 'выберите роль'
                }
            });

            $(".js-select2").select2({
                closeOnSelect : false,
                placeholder : "Placeholder",
                // allowHtml: true,
                allowClear: true,
                tags: false // создает новые опции на лету
            });
        });


    </script>
@stop
