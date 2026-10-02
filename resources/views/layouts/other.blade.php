@extends('layouts.app')
@section('app.content')
    <div class="container">
        <x-laravel-seo::breadcrumbs/>
    </div>
    @yield('content')
@endsection
