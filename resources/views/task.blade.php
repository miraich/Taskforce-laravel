@extends('layouts.app')

@section('title', "$task->title")

@section('stars-js')
    <script src="https://kit.fontawesome.com/bc693717e3.js" crossorigin="anonymous"></script>
@endsection

@section('y-maps-js')
    <script src="https://api-maps.yandex.ru/2.1/?be1bd94b-85a3-451f-b5b8-1dd420c530bd&lang=ru_RU"
            type="text/javascript">
    </script>
@endsection

@section('content')
    <div class="left-column">
        <div class="head-wrapper">
            <h3 class="head-main">{{$task->title}}</h3>
            <p class="price price--big">{{$task->budget . ' ₽'}}</p>
        </div>
        <p class="task-description">
            {{$task->description}}</p>

        @switch(\Illuminate\Support\Facades\Auth::user()->role_id)
            @case(\App\Enums\RolesEnum::CLIENT->value)
                @switch($task->status_id)
                    @case($task->status_id===\App\Enums\StatusesEnum::STATUS_NEW->value and $task->client_id===\Illuminate\Support\Facades\Auth::user()->id)
                        <a href="#" class="button button--blue action-btn" data-action="deny">Отменить задание</a>
                        @break
                    @case($task->status_id===\App\Enums\StatusesEnum::IN_PROGRESS->value and $task->client_id===\Illuminate\Support\Facades\Auth::user()->id)
                        <a href="#" class="button button--pink action-btn" data-action="completion">Завершить
                            задание</a>
                @endswitch
                @break
            @case(\App\Enums\RolesEnum::EXECUTOR->value)
                @switch($task->status_id)
                    @case($task->status_id===\App\Enums\StatusesEnum::STATUS_NEW->value and \Illuminate\Support\Facades\Auth::user()->role_id===2)
                        <a href="#" class="button button--blue action-btn" data-action="act_response">Откликнуться
                            на
                            задание</a>
                        @break
                    @case($task->status_id===\App\Enums\StatusesEnum::IN_PROGRESS->value and \Illuminate\Support\Facades\Auth::user()->id===$task->executor_id)
                        <a href="#" class="button button--orange action-btn" data-action="refusal">Отказаться от
                            задания</a>
                @endswitch
        @endswitch

        @if($task->city_id)
            <div class="task-map">
                <div id="YMapsID" style="width: 725px; height: 346px;"></div>
                <p class="map-address town">{{$task->address}}</p>
                <p class="map-address">{{$task->city->name}}</p>
            </div>
        @endif

        <h4 class="head-regular">Отклики на задание</h4>
        @foreach($task->responses as $response)
            <div class="response-card">
                <img class="customer-photo" src="img/man-glasses.png" width="146" height="156"
                     alt="Фото заказчиков">
                <div class="feedback-wrapper">
                    @if($response->user->id===\Illuminate\Support\Facades\Auth::user()->id)
                        <a href="#" class="link link--block link--big">{{$response->user->name.' | '.'Ваш отклик'}}</a>
                    @else
                        <a href="#" class="link link--block link--big">{{$response->user->name}}</a>
                    @endif
                    <div class="response-wrapper">
                        <div class="stars-rating small"><span class="fill-star">&nbsp;</span><span
                                    class="fill-star">&nbsp;</span><span
                                    class="fill-star">&nbsp;</span><span
                                    class="fill-star">&nbsp;</span><span>&nbsp;</span>
                        </div>
                        <p class="reviews">2 отзыва</p>
                    </div>
                    <p class="response-message">
                        {{$response->commentary}}
                    </p>

                </div>
                <div class="feedback-wrapper">
                    <p class="info-text"><span
                                class="current-time">{{$carbon->diffForHumans($response->created_at)}}</span></p>
                    <p class="price price--small">{{$response->budget. ' ₽'}} </p>
                </div>
                @if(\Illuminate\Support\Facades\Auth::user()->id===$task->client_id and $task->status_id===1 )
                    <div class="button-popup">
                        <a href="#" class="button button--blue button--small">Принять</a>
                        <a href="#" class="button button--orange button--small">Отказать</a>
                    </div>
                @endif
            </div>
        @endforeach

    </div>
    <div class="right-column">
        <div class="right-card black info-card">
            <h4 class="head-card">Информация о задании</h4>
            <dl class="black-list">
                <dt>Категория</dt>
                <dd>{{$task->category->name}}</dd>
                <dt>Дата публикации</dt>
                <dd>{{$carbon->diffForHumans($task->created_at)}}</dd>
                <dt>Срок выполнения</dt>
                <dd>{{'До '.$exp_date->isoFormat('Do MMMM, YYYY')}}</dd>
                <dt>Статус</dt>
                <dd>{{$task->status->name}}</dd>
            </dl>
        </div>
        @if($task->files()->exists())
            <div class="right-card white file-card">
                <h4 class="head-card">Файлы задания</h4>
                <ul class="enumeration-list">
                    @foreach($files = $task->files as $file)
                        <li class="enumeration-item">
                            <a href="{{route('task.get_file',$file->file_path)}}"
                               class="link link--block link--clip">{{$file->file_path}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <section class="pop-up pop-up--refusal pop-up--close">
        <div class="pop-up--wrapper">
            <h4>Отказ от задания</h4>
            <p class="pop-up-text">
                <b>Внимание!</b><br>
                Вы собираетесь отказаться от выполнения этого задания.<br>
                Это действие плохо скажется на вашем рейтинге и увеличит счетчик проваленных заданий.
            </p>
            <a class="button button--pop-up button--orange">Отказаться</a>
            <div class="button-container">
                <button class="button--close" type="button">Закрыть окно</button>
            </div>
        </div>
    </section>
    <section class="pop-up pop-up--completion pop-up--close">
        <div class="pop-up--wrapper">
            <h4>Завершение задания</h4>
            <p class="pop-up-text">
                Вы собираетесь отметить это задание как выполненное.
                Пожалуйста, оставьте отзыв об исполнителе и отметьте отдельно, если возникли проблемы.
            </p>
            <div class="completion-form pop-up--form regular-form">
                <form>
                    <div class="form-group">
                        <label class="control-label" for="completion-comment">Ваш комментарий</label>
                        <textarea id="completion-comment"></textarea>
                    </div>
                    <p class="completion-head control-label">Оценка работы</p>
                    <div class="rating">
                        <span class="rating__result"></span>
                        <i class="rating__star far fa-star"></i>
                        <i class="rating__star far fa-star"></i>
                        <i class="rating__star far fa-star"></i>
                        <i class="rating__star far fa-star"></i>
                        <i class="rating__star far fa-star"></i>
                    </div>
                    <input type="submit" class="button button--pop-up button--blue" value="Завершить">
                </form>
            </div>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
        </div>
    </section>
    <section class="pop-up pop-up--act_response pop-up--close">
        <div class="pop-up--wrapper">
            <h4>Добавление отклика к заданию</h4>
            <p class="pop-up-text">
                Вы собираетесь оставить свой отклик к этому заданию.
                Пожалуйста, укажите стоимость работы и добавьте комментарий, если необходимо.
            </p>
            <div class="addition-form pop-up--form regular-form">
                <form action="{{route('task.to_response',$task->id)}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="control-label" for="addition-comment">Ваш комментарий</label>
                        <textarea name="commentary" id="addition-comment"></textarea>
                        @error('commentary')
                        {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="addition-price">Стоимость</label>
                        <input name="budget" id="addition-price" type="text">
                        @error('budget')
                        {{$message}}
                        @enderror
                    </div>
                    <input type="submit" class="button button--pop-up button--blue" value="Завершить">
                </form>
            </div>
            <div class="button-container">
                <button class="button--close" type="button">Закрыть окно</button>
            </div>
        </div>
    </section>
    <div class="overlay"></div>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{asset('assets/js/stars.js')}}"></script>
@endsection('content')

@section('view-y-map-js')
    <script type="text/javascript">
        ymaps.ready(function () {
            var myMap = new ymaps.Map("YMapsID", {
                center: [{{$task->lat}}, {{$task->long}}],
                zoom: 16
            });

            var myGeoObject = new ymaps.GeoObject({
                geometry: {
                    type: "Point", // тип геометрии - точка
                    coordinates: [{{$task->lat}}, {{$task->long}}] // координаты точки
                }
            });

            myMap.geoObjects.add(myGeoObject);

            myMap.controls.remove('trafficControl');
            myMap.controls.remove('searchControl');
            myMap.controls.remove('geolocationControl');
            myMap.controls.remove('typeSelector');
            myMap.controls.remove('fullscreenControl');
            myMap.controls.remove('rulerControl');
        });
    </script>
@endsection
