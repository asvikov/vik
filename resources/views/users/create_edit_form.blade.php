<form action="{{$action}}" method="POST" id="create_user_form">
    @csrf
    @method($method)
    <div class="mb-3">
        <label for="name" class="form-label">Имя</label>
        <input name="name" class="form-control" type="text" value="{{$user->name ? $user->name : old('name')}}">
    </div>
    <div class="mb-3">
        <label for="lastname" class="form-label">Фамилия</label>
        <input name="lastname" class="form-control" type="text" value="{{$user->lastname ? $user->lastname : old('lastname')}}">
    </div>
    <div class="mb-3">
        <label for="surname" class="form-label">Отчество</label>
        <input name="surname" class="form-control" type="text" value="{{$user->surname ? $user->surname : old('surname')}}">
        <div>не обязательное поле</div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input name="email" class="form-control" type="email"  value="{{$user->email ? $user->email : old('email')}}">
        <div>будет использоваться как логин для входа</div>
    </div>
    <div class="mb-3 row">
        <label for="roles[]" class="form-label">выберите роль</label>
        <select name="roles[]" class="js-select2 form-select" multiple>
            @foreach($roles as $role)
                <option value="{{$role->id}}" {{$role->selected ? 'selected' : ''}}>{{$role->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Пароль</label>
        <input name="password" class="form-control" type="password">
    </div>
    <div class="mb-3">
        <label class="form-label">Еще раз пароль</label>
        <input name="password_confirmation" class="form-control" type="password" id="password_confirmation">
    </div>
    <div class="mb-3 float-end">
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{url('/users')}}" class="btn btn-primary">Отменить</a>
    </div>
</form>
