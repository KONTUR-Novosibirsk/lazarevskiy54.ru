@extends('layouts.app')
@section('app.content')
    <div class="breadcrumbs-container container">
        <x-laravel-seo::breadcrumbs/>
    </div>
    @yield('content')
@endsection
