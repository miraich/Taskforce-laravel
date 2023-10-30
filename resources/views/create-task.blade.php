@extends('layouts.app')

@section('title', "$task->title")

@section('stars-js')
    <script src="https://kit.fontawesome.com/bc693717e3.js" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="left-column">
        <div class="head-wrapper">
            <h3 class="head-main">{{$task->title}}</h3>
            <p class="price price--big">{{$task->budget . ' ₽'}}</p>
        </div>
        <p class="task-description">
            {{$task->description}}</p>

        <a href="#" class="button button--blue action-btn" data-action="act_response">Откликнуться на задание</a>
        <a href="#" class="button button--orange action-btn" data-action="refusal">Отказаться от задания</a>
        <a href="#" class="button button--pink action-btn" data-action="completion">Завершить задание</a>
        <a href="#" class="button button--blue action-btn" data-action="deny">Отменить задание</a>

        <div class="task-map">
            <img class="map" src="img/map.png" width="725" height="346" alt="{{$task->address}}">
            <p class="map-address town">{{$task->address}}</p>
            <p class="map-address">{{$task->city->name}}</p>
        </div>
        <h4 class="head-regular">Отклики на задание</h4>
        @foreach($responses as $response)
            <div class="response-card">
                <img class="customer-photo" src="img/man-glasses.png" width="146" height="156" alt="Фото заказчиков">
                <div class="feedback-wrapper">
                    <a href="#" class="link link--block link--big">name</a>
                    <div class="response-wrapper">
                        <div class="stars-rating small"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span
                                class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span>
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
                <div class="button-popup">
                    <a href="#" class="button button--blue button--small">Принять</a>
                    <a href="#" class="button button--orange button--small">Отказать</a>
                </div>
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
        <div class="right-card white file-card">
            <h4 class="head-card">Файлы задания</h4>
            <ul class="enumeration-list">
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--clip">my_picture.jpg</a>
                    <p class="file-size">356 Кб</p>
                </li>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--clip">information.docx</a>
                    <p class="file-size">12 Кб</p>
                </li>
            </ul>
        </div>
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
                <form>
                    <div class="form-group">
                        <label class="control-label" for="addition-comment">Ваш комментарий</label>
                        <textarea id="addition-comment"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="addition-price">Стоимость</label>
                        <input id="addition-price" type="text">
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
