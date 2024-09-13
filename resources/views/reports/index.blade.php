@extends('layout')
@section('title')
    список отчетов
@stop
@section('main_body')
    <div class="container">
        <div class="mt-3 px-2">
            <div class="js-fil-main row align-items-center">
                <div class="col-auto">
                    <span>от:</span>
                </div>
                <div class="col-auto">
                    <input type="date" class="js-fil-date-from form-control">
                </div>
                <div class="col-auto">
                    <span>до:</span>
                </div>
                <div class="col-auto">
                    <input type="date" class="js-fil-date-to form-control">
                </div>
                <div class="col-auto">
                    <span>менеджер:</span>
                </div>
                <div class="col-auto">
                    <select class="js-fil-man form-select">
                        <option value="" disabled selected>Все</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->lastname.' '.$user->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="button" class="js-fil-go btn btn-outline-secondary">сводный отчет</button>
                    <button type="button" class="js-fil-cancel btn btn-outline-secondary">отменить</button>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Менеджер</th>
                <th scope="col">дата создания</th>
                <th scope="col">выручка</th>
                <th scope="col"><a href="{{route('reports.create')}}" class="text-decoration-none">+ добавить</a></th>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
                <tr data-id="{{$report->id}}">
                    <td class="js-show cur-p">{{$report->user->lastname.' '.$report->user->name}}</td>
                    <td class="js-show cur-p">{{\Carbon\Carbon::parse($report->created_at)->format('d.m.Y')}}</td>
                    <td class="js-show cur-p">{{$report->income}} р.</td>
                    <td>
                        @canany(['update', 'delete'], $report)
                            <span data-id="{{$report->id}}" class="js-a-del cur-p btn-link text-decoration-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                </svg>
                            </span>
                            <a href="{{url('/reports/'.$report->id.'/edit')}}" class="offset-1 text-decoration-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </a>
                        @endcanany
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
@section('script')
    <script>
        $('.js-a-del').on('click', function (event) {
            let elem = this;
            let id = this.dataset.id;
            let url = '/reports/'+id;
            let body = {
                _token: '{!! @csrf_token() !!}'
            };

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(body)
            })
                .then(response => {
                    if(response.ok) {
                        let tr_par = elem.closest('tr');
                        $(tr_par).fadeOut('fast');
                    }
                });
        });

        $('.js-show').on('click', function (event) {
            let id = $(this).parent().data('id');
            window.location.href = 'reports/'+id;
        });

        function setGetParamReports() {
            let params = new URLSearchParams(document.location.search);
            let dfrom = params.get('dfrom');
            let dto = params.get('dto');
            let manager = params.get('manager');

            if(dfrom && dto) {
                $('.js-fil-date-from').val(dfrom);
                $('.js-fil-date-to').val(dto);
            }

            if(manager) {
                $('.js-fil-man').val(manager);
            }
        }
        setGetParamReports();

        $('.js-fil-main').on('click', function (event) {
            let url = window.location;
            let clear_url = url.origin + url.pathname;

            if(event.target.classList.contains('js-fil-go')) {
                let get_params = {
                    dfrom: $('.js-fil-date-from').val(),
                    dto: $('.js-fil-date-to').val(),
                    manager: $('.js-fil-man').val()
                }
                let is_data_fill = (!get_params.dfrom.length === !get_params.dto.length);
                let is_data_correct = true;

                if(get_params.dfrom.length && get_params.dto.length) {
                    let data_from = new Date(get_params.dfrom);
                    let data_to = new Date(get_params.dto);
                    is_data_correct = (data_from.getTime() <= data_to.getTime());
                }
                let get_params_query = '';
                let dev_char = '?';

                if(!is_data_fill || !is_data_correct) {
                    $('.js-fil-date-from').addClass('border-danger');
                    $('.js-fil-date-to').addClass('border-danger');
                } else {
                    for(key in get_params) {
                        get_params_query += get_params[key] ? (dev_char + key + '=' + get_params[key]) : '';

                        if(get_params_query.length) {
                            dev_char = '&';
                        }
                    }
                    if(get_params_query.length) {
                        window.location.href = clear_url + get_params_query;
                    }
                }
            } else if(event.target.classList.contains('js-fil-cancel')) {
                if(window.location.search.length) {
                    window.location.href = clear_url;
                }
            }
        });
    </script>
@stop
