@extends('layout')
@section('title')
    отчет {{$report->id}}
@stop
@section('main_body')
    <div class="container-xl p-3">
        <div class="initialism mb-3">отчет #{{$report->id}}</div>
        <div class="row">
            <div class="col-lg-auto">
                <div>Менеджер:</div>
                <div class="mb-2">{{$report->user->lastname.' '.$report->user->name.' '.$report->user->surname}}</div>
                <div>Выручка:</div>
                <div class="mb-2">{{$report->income}}</div>
                <div>Дата создания:</div>
                <div>{{\Carbon\Carbon::parse($report->create_at)->format('d-m-Y')}}</div>
            </div>
            <div class="col-lg">
                @foreach($report->addresses as $address)
                    <div class="mb-2">
                        <div>Адрес #{{$loop->iteration}}:</div>
                        <div>{{$address->city.', ул. '.$address->street.' '.$address->house.', '.$address->apt}}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop
@section('script')
@stop
