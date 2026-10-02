@extends('layouts.other')
@section('content')
    <div class="container">
        <h1>{{ seo()->metaData()->getH1() ?? settings('name', 'services', 'Услуги') }}</h1>
        {!! settings('content', 'services', '') !!}
        @foreach($services as $service)
            <x-services::items.service-card :service="$service"/>
        @endforeach
        {{ $services->links() }}
    </div>
@endsection
