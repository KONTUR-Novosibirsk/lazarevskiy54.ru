@extends('layouts.other')
@section('content')
    <div class="container">
        <h1>{{ seo()->metaData()->getH1() ?? $sale->title }}</h1>
        @if($sale->start_date)
            <div class="">
                <span>Дата начала:</span> {{ $sale->start_date->isoFormat('LLL') }}
            </div>
        @endif
        @if($sale->end_date)
            <div class="">
                <span>Дата окончания:</span> {{ $sale->end_date->isoFormat('LLL') }}
            </div>
        @endif
        <div class="ck-content">
            {!! $sale->text !!}
        </div>
    </div>
@endsection
