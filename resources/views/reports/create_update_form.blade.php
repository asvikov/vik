<form action="{{$action}}" method="POST" id="cu_report_form">
    @csrf
    @method($method)
    <div class="row mb-3 align-items-center">
        <div class="col-4">
            <select name="user_id" class="form-select" aria-describedby="user_id">
                @foreach($users as $user)
                    <option value="{{$user->id}}" {{($user->id == $current_user_id) ? 'selected' : ''}}>{{$user->name.' '.$user->lastname.' '.$user->surname}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <span id="user_id" class="form-text">ФИО менеджера</span>
        </div>
    </div>
    <div class="row mb-3 align-items-center">
        <div class="col-4">
            <input type="text" name="income" class="form-control" aria-describedby="income" value="{{$report->income ? $report->income : 0}}">
        </div>
        <div class="col-auto">
            <span id="surname" class="form-text">Дневная выручка</span>
        </div>
    </div>
    <div class="mb-3">Адрес точки продаж:</div>
    <div class="mb-3" id="address-items">
        @if($report->addresses)
            @foreach($report->addresses as $cur_ad)
                <div class="d-flex align-items-center" data-city="{{$cur_ad->city}}" data-street="{{$cur_ad->street}}" data-house="{{$cur_ad->house}}" data-apt="{{$cur_ad->apt}}">
                    <div class="count-address p-2">{{$loop->iteration}}</div>
                    <div class="text-address col-4">{{$cur_ad->city.', ул. '.$cur_ad->street.' '.$cur_ad->house.', '.$cur_ad->apt}}</div>
                    <span class="close-address float-end btn-link cur-p text-decoration-none">×</span>
                </div>
            @endforeach
        @endif
    </div>
    <div class="example-address-item d-flex align-items-center" data-city="" data-street="" data-house="" data-apt="" hidden>
        <div class="count-address p-2" hidden></div>
        <div class="text-address col-4" hidden></div>
        <span class="close-address float-end btn-link cur-p text-decoration-none" hidden>×</span>
    </div>
    <div class="d-flex">
        <div class="js-num-sec p-2">1</div>
        <div class="js-address-main flex-grow-1">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col-4">
                    <input type="text" list="city" name="city" class="form-control" aria-describedby="desc-city">
                    <datalist id="city">
                        @foreach($addresses_unique['cities'] as $city)
                            <option value="{{$city}}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-auto">
                    <span id="desc-city" class="form-text">Город</span>
                </div>
            </div>
            <div class="row g-3 mb-3 align-items-center">
                <div class="col-4">
                    <input type="text" list="street" name="street" class="form-control" aria-describedby="desc-street">
                    <datalist id="street">
                        @foreach($addresses_unique['streets'] as $street)
                            <option value="{{$street}}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-auto">
                    <span id="desc-street" class="form-text">Улица</span>
                </div>
            </div>
            <div class="row g-3 mb-3 align-items-center">
                <div class="col-4">
                    <input type="text" list="house" name="house" class="form-control" aria-describedby="desc-house">
                    <datalist id="house">
                        @foreach($addresses_unique['houses'] as $house)
                            <option value="{{$house}}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-auto">
                    <span id="desc-house" class="form-text">Дом (корпус)</span>
                </div>
            </div>
            <div class="row g-3 mb-3 align-items-center">
                <div class="col-4">
                    <input type="text" list="apt" name="apt" class="form-control" aria-describedby="desc-apt">
                    <datalist id="apt">
                        @foreach($addresses_unique['apts'] as $apt)
                            <option value="{{$apt}}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-auto">
                    <span id="desc-apt" class="form-text">Квартира или офис, при наличии</span>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-link cur-p text-decoration-none mb-4" id="add-sale-point">+ добавить еще точку продаж</div>
    <div>
        <button type="submit" id="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{url('/reports')}}" class="btn btn-primary">Отменить</a>
    </div>
</form>
