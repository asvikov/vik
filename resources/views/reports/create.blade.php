@extends('layout')
@section('title')
    создать ежедневный отчет
@stop
@section('main_body')
    <div class="container">
        <div class="my-sm-3 initialism">создать отчет</div>
        @include('reports/create_update_form', ['action' => route('reports.store'), 'method' => 'POST'])
        @include('errors/list')
    </div>
@stop
@section('script')
    <script>
        let cu_report_form = $('#cu_report_form');

        cu_report_form.validate({
            rules: {
                user_id: 'required',
                income: {
                    required: true,
                    number: true
                },
                city: 'required',
                street: 'required',
                house: 'required'
            },
            messages: {
                user_id: 'выберите менеджера',
                income: {
                    required: 'введите дневную выручку',
                    number: 'должна быть в формате 123 или 123.45'
                },
                city: 'выберите город из предложенных или введите свой',
                street: 'выберите улицу из предложенных или введите свою',
                house: 'выберите дом из предложенных или введите свой'
            }
        });

        function sendReportRequest() {
            let body = {
                _token: "{!! @csrf_token() !!}",
                user_id: $('[name=user_id]').val(),
                income: $('[name=income]').val(),
                addresses: []
            };

            $('#address-items').children().each(function () {
                let self = $(this);
                let address_item = {
                    city: self.data('city'),
                    street: self.data('street'),
                    house: self.data('house')
                }

                if(self.data('apt').length) {
                    address_item.apt = self.data('apt');
                }
                body.addresses.push(address_item);
            });

            let last_address_item = {
                city: $('[name=city]').val(),
                street: $('[name=street]').val(),
                house: $('[name=house]').val()
            }

            if($('[name=apt]').val().length) {
                last_address_item.apt = $('[name=apt]').val();
            }
            body.addresses.push(last_address_item);

            fetch('/reports', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(body)
            })
                .then(response => {
                    if(response.ok) {
                        window.location.href = '/reports';
                    }
                });
        }

        cu_report_form.on('submit', function (event) {
            event.preventDefault();
            let is_validate = cu_report_form.valid();

            if(is_validate) {
                sendReportRequest();
            }
        });

        $('#add-sale-point').on('click', function (event) {
            let is_validate = cu_report_form.valid();

            if(is_validate) {
                let city = $('[name=city]').val();
                let street = $('[name=street]').val();
                let house = $('[name=house]').val();
                let apt = $('[name=apt]').val();
                let apt_text = '';

                if(apt.length) {
                    apt_text = ', ' + apt;
                }

                let address_items = $('#address-items');
                let length = address_items.children().length;
                let num_item = length + 1;
                let example_item = $('.example-address-item').clone();
                example_item = example_item.removeClass('example-address-item');
                example_item.data('city', city);
                example_item.data('street', street);
                example_item.data('house', house);
                example_item.data('apt', apt);
                example_item.removeAttr('hidden');
                example_item.children('.count-address').html(num_item);
                example_item.children('.text-address').html(city + ', ул. ' + street + ' ' + house + apt_text);
                example_item.children().removeAttr('hidden');

                example_item.children('.close-address').on('click', removeAddressFromList);
                address_items.append(example_item);
                $('.js-address-main input').val('');
                $('.js-num-sec').html(num_item + 1);
            }
        });

        function removeAddressFromList (event) {
            $(this).parent().remove();
            let items = $('#address-items').find('.count-address');

            items.each(function (index) {
                let count = index + 1;
                $(this).html(count);
            });
            let length = items.length;
            $('.js-num-sec').html(length + 1);
        }
    </script>
@stop
