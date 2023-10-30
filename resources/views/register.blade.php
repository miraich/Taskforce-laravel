@extends('layouts.app')

@section('title', "Регистрация")

@section('content')
    <div class="center-block">
        <div class="registration-form regular-form">
            <form action="{{route('auth.register')}}" method="POST" id="register-form">
                @csrf
                @method('post')
                <h3 class="head-main head-task">Регистрация нового пользователя</h3>
                <div class="form-group">
                    <label class="control-label" for="username">Ваше имя</label>
                    <input id="username" type="text" name="username" class="form-control" value="{{ old('username') }}">
                    @error('username')
                    <span class="is-invalid">{{ $message }}</span>
                    @else
                        <span class="help-block"></span>
                        @enderror
                </div>
                <div class="half-wrapper">
                    <div class="form-group">
                        <label class="control-label" for="email-user">Email</label>
                        <input id="email-user" type="email" name="email" class="form-control"
                               value="{{ old('email') }}">
                        @error('email')
                        <div class="is-invalid">{{ $message }}</div>
                        @else
                            <span class="help-block"></span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="town-user">Город</label>
                        <select name="city" id="town-user">
                            @foreach($cities as $city)
                                <option value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                        @error('city')
                        <div class="is-invalid">{{ $message }}</div>
                        @else
                            <span class="help-block"></span>
                            @enderror
                    </div>
                </div>
                <div class="half-wrapper">
                    <div class="form-group">
                        <label class="control-label" for="password-user">Пароль</label>
                        <input id="password-user" type="password" name="password">
                        @error('password')
                        <div class="is-invalid">{{ $message }}</div>
                        @else
                            <span class="help-block"></span>
                            @enderror
                    </div>

                </div>
                <div class="half-wrapper">

                    <div class="form-group">
                        <label class="control-label" for="password-repeat-user">Повтор пароля</label>
                        <input id="password-repeat-user" type="password" name="password_confirmation">
                        @error('password_confirmation')
                        <div class="is-invalid">{{ $message }}</div>
                        @else
                            <span class="help-block"></span>
                            @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label checkbox-label" for="response-user">
                        <input id="response-user" type="checkbox" checked name="is_executor">
                        Я собираюсь откликаться на заказы</label>
                </div>
                <input type="submit" class="button button--blue" value="Создать аккаунт">
            </form>
        </div>
    </div>



@endsection('content')


