@extends('layouts.other')
@section('content')
    <section class="error">
        <div class="error-container container">
            <div class="error-code">
                404
            </div>
            <div class="error-title">
                Страница не найдена
            </div>
            <div class="error-description">
                Запрашиваемой страницы не существует. Возможно, она была удалена или в запросе указан неверный адрес.
            </div>
            <a href="{{ route('index') }}" class="error-btn">Вернуться на главную</a>
        </div>
    </section>
@endsection
