@extends('layouts.other')
@section('content')
    <div class="container">
        <h1>{{ seo()->metaData()->getH1() ?? $service->name }}</h1>
        @if($service->price)
            <div class="">
                <span>Стоимость:</span> {{ $service->price }}
            </div>
        @endif
        <div class="ck-content">
            {!! $service->content !!}
        </div>
    </div>
@endsection
