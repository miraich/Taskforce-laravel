@extends('layouts.app')

@section('title', 'Объявления')

@section('content')
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>
        @foreach($tasks as $task)
            <div class="task-card">
                <div class="header-task">
                    <a href="{{route('task.show',['task'=>$task->id])}}"
                       class="link link--block link--big">{{$task->title}}</a>
                    <p class="price price--task">{{$task->budget . ' ₽'}}</p>
                </div>
                <p class="info-text"><span
                        class="current-time">{{$carbon->diffForHumans($task->created_at)}} </span></p>
                <p class="task-text">{{$task->description}}
                </p>
                <div class="footer-task">
                    @if($task->city)
                        <p class="info-text town-text">{{$task->city->name}}</p>
                    @endif
                    <p class="info-text category-text">{{$task->category->name}}</p>
                    <a href="{{route('task.show',['task'=>$task->id])}}" class="button button--black">Смотреть
                        Задание</a>
                </div>
            </div>
        @endforeach
        {{ $tasks->appends(Request::all())->links() }}

        {{--                <div class="pagination-wrapper">--}}
        {{--                    <ul class="pagination-list">--}}
        {{--                        <li class="pagination-item mark">--}}
        {{--                            <a href="#" class="link link--page"></a>--}}
        {{--                        </li>--}}
        {{--                        <li class="pagination-item">--}}
        {{--                            <a href="#" class="link link--page">1</a>--}}
        {{--                        </li>--}}
        {{--                        <li class="pagination-item pagination-item--active">--}}
        {{--                            <a href="#" class="link link--page">2</a>--}}
        {{--                        </li>--}}
        {{--                        <li class="pagination-item">--}}
        {{--                            <a href="#" class="link link--page">3</a>--}}
        {{--                        </li>--}}
        {{--                        <li class="pagination-item mark">--}}
        {{--                            <a href="#" class="link link--page"></a>--}}
        {{--                        </li>--}}
        {{--                    </ul>--}}
        {{--                </div>--}}
    </div>
    <div class="right-column">
        <div class="right-card black">
            <div class="search-form">
                <form method="post" action="{{route('tasks.index')}}">
                    @csrf
                    @method('post')
                    <h4 class="head-card">Категории</h4>
                    <div class="form-group">
                        <div class="checkbox-wrapper">
                            @foreach($categories as $category)
                                <label class="control-label" for="{{$category->icon}}">
                                    <input type="checkbox" name="options[category][]" value="{{$category->id}}"
                                           @if(isset(request()->input('options')['category'])&&in_array($category->id,request()->input('options')['category']))
                                               checked
                                           @endif
                                           id="{{$category->icon}}">
                                    {{$category->name}}</label>
                            @endforeach
                        </div>
                    </div>
                    <h4 class="head-card">Дополнительно</h4>
                    <div class="form-group">
                        <label class="control-label" for="without-performer">
                            <input id="without-performer" name="options[additional][]" value="without-performer"
                                   @if(isset(request()->input('options')['additional'])&&in_array("without-performer",request()->input('options')['additional']))
                                       checked
                                   @endif
                                   type="checkbox">
                            Без исполнителя</label>
                        <br>
                        <label class="control-label" for="distant-work">
                            <input id="distant-work" name="options[additional][]" value="distant"
                                   @if(isset(request()->input('options')['additional'])&&in_array("distant",request()->input('options')['additional']))
                                       checked
                                   @endif
                                   type="checkbox">
                            Удалённая работа</label>
                    </div>
                    <h4 class="head-card">Период</h4>
                    <div class="form-group">
                        <label for="period-value"></label>
                        <select name="options[time]" id="period-value">
                            @if(isset(request()->input('options')['time']))
                                @switch(request()->input('options')['time'])
                                    @case('3600')
                                        <option selected value="3600">За последний час</option>
                                        <option value="86400">За сутки</option>
                                        <option value="604800">За неделю</option>
                                        @break
                                    @case('86400')
                                        <option value="3600">За последний час</option>
                                        <option selected value="86400">За сутки</option>
                                        <option value="604800">За неделю</option>
                                        @break
                                    @case('604800')
                                        <option value="3600">За последний час</option>
                                        <option value="86400">За сутки</option>
                                        <option selected value="604800">За неделю</option>
                                @endswitch
                                @else
                                <option value="3600">За последний час</option>
                                <option value="86400">За сутки</option>
                                <option selected value="604800">За неделю</option>
                            @endif
                        </select>
                    </div>
                    <input type="submit" class="button button--blue" value="Искать">
                </form>
            </div>
        </div>
    </div>
@endsection('content')
