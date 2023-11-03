@extends('layouts.app')


@section('title', "Создать задание")

@section('suggest-js')

    <script
        src="https://api-maps.yandex.ru/2.1/?apikey=be1bd94b-85a3-451f-b5b8-1dd420c530bd&suggest_apikey=69566ac7-bb86-4ff9-9e61-ec28ccc97515&lang=ru_RU"
        type="text/javascript"></script>

@endsection

@section('content')
    <div class="add-task-form regular-form center-block">
        <form action="{{route('task.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('post')
            <h3 class="head-main head-main">Публикация нового задания</h3>
            <div class="form-group">
                <label class="control-label" for="essence-work">Опишите суть работы</label>
                <input id="essence-work" type="text" name="title">
                {{--                <span class="help-block">Error description is here</span>--}}
                @error('title')
                <div class="is-invalid">{{ $message }}</div>
                @else
                    <span class="help-block"></span>
                    @enderror

            </div>
            <div class="form-group">
                <label class="control-label" for="username">Подробности задания</label>
                <textarea id="username" name="description"></textarea>
                @error('description')
                <div class="is-invalid">{{ $message }}</div>
                @else
                    <span class="help-block"></span>
                    @enderror
            </div>
            <div class="form-group">
                <label class="control-label" for="town-user">Категория</label>
                <select name="category" id="town-user">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category')
                <div class="is-invalid">{{ $message }}</div>
                @else
                    <span class="help-block"></span>
                    @enderror
            </div>
            <div class="form-group">
                <label class="control-label" for="address">Локация</label>
                <input class="location-icon" id="address" type="text" name="address">
                @error('address')
                <div class="is-invalid">{{ $message }}</div>
                @else
                    <span class="help-block"></span>
                    @enderror
            </div>
            <div class="half-wrapper">
                <div class="form-group">
                    <label class="control-label" for="budget">Бюджет</label>
                    <input class="budget-icon" id="budget" type="text" name="budget">
                    @error('budget')
                    <div class="is-invalid">{{ $message }}</div>
                    @else
                        <span class="help-block"></span>
                        @enderror
                </div>
                <div class="form-group">
                    <label class="control-label" for="period-execution">Срок исполнения</label>
                    <input id="period-execution" type="date" name="deadline">
                    @error('deadline')
                    <div class="is-invalid">{{ $message }}</div>
                    @else
                        <span class="help-block"></span>
                        @enderror
                </div>
            </div>
            <p class="form-label">Файлы</p>
            <div class="form-group">
                <input type="file" name="files[]" multiple>
                <input type="submit" class="button button--blue" value="Опубликовать">
            </div>
        </form>
    </div>
@endsection('content')

@section('suggest-js-script')
    <script type="text/javascript">
        ymaps.ready(init);
        function init() {
            var suggestView = new ymaps.SuggestView('address');
            suggestView.events.add('select', function (event) {
                var selected = event.get('item').value;
                ymaps.geocode(selected, {
                    results: 1
                }).then(function (res) {
                    return ymaps.geocode(res.geoObjects.get(0).geometry.getCoordinates(), {
                        kind: 'district',
                        results: 10
                    }).then(function (res) {
                        var founded = res['metaData']['geocoder']['found'];
                        $('label.suggest .description').html("");
                        for (i = 0; i <= founded - 1; i++) {
                            var info = res.geoObjects.get(i).properties.getAll();
                            console.log(info);
                            var name = info['name'];
                            if (name.search('район') != -1) {
                                name = name.replace(' район', '');
                                console.log(name);
                            }
                        }
                    });
                });
            });
        }
    </script>
@endsection



