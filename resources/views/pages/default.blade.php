@extends('layouts.other')
@section('content')
    <div class="container">
        <h1>{{ seo()->metaData()->getH1() ?? $page->title }}</h1>
        <div class="ck-content">
            {!! $page->text !!}
        </div>
    </div>
@endsection
