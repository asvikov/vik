@extends('layout')
@section('title')редактировать пользователя@stop
@section('main_body')
    <div class="container px-1">
        <div class="my-sm-3 initialism">редактировать пользователя</div>
        @include('users/create_edit_form', ['action' => url('/users/'.$user->id), 'method' => 'PUT'])
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
