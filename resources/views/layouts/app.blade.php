<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    @yield('stars-js')
    @yield('suggest-js')
    @yield('y-maps-js')
</head>
<body>
@auth()
    <header class="page-header">
        <nav class="main-nav">
            <a href='{{route('tasks.index')}}' class="header-logo">
                <img class="logo-image" src="{{asset('assets/img/logotype.png')}}" width=227 height=60 alt="taskforce">
            </a>
            <div class="nav-wrapper">
                <ul class="nav-list">
                    <li class="list-item {{request()->routeIs('tasks.index') ? 'list-item--active' : '' }}">
                        <a href="{{route('tasks.index')}}" class="link link--nav">Новое</a>
                    </li>
                    <li class="list-item">
                        <a href="#" class="link link--nav">Мои задания</a>
                    </li>
                    <li class="list-item {{request()->routeIs('task.show_store') ? 'list-item--active' : '' }}">
                        <a href="{{route('task.show_store')}}" class="link link--nav">Создать задание</a>
                    </li>
                    <li class="list-item">
                        <a href="#" class="link link--nav">Настройки</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="user-block">
            @if(Auth::user()->avatar)
                <a href="#">
                    <img class="user-photo" src="img/man-glasses.png" width="55" height="55" alt="Аватар">
                </a>
            @endif
            <div class="user-menu">
                <p class="user-name">{{Auth::user()->name }}</p>
                <div class="popup-head">
                    <ul class="popup-menu">
                        <li class="menu-item">
                            <a href="#" class="link">Настройки</a>
                        </li>
                        {{--                    <li class="menu-item">--}}
                        {{--                        <a href="#" class="link">Связаться с нами</a>--}}
                        {{--                    </li>--}}
                        <li class="menu-item">
                            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST">
                                @csrf
                                <button type="submit">
                                    {{ __('Logout') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
@endauth
<main class="main-content container">
    @yield('content')
</main>
</body>
@yield('suggest-js-script')
@yield('view-y-map-js')
</html>
