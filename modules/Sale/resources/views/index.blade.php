@extends('layouts.other')
@section('content')
    <div class="container">
        <h1>{{ seo()->metaData()->getH1() ?? settings('name', 'sale', 'Акции') }}</h1>
        @forelse($items as $item)
            {{ $item->title }}
        @empty
            <div class="">Записи отсутствуют</div>
        @endforelse

        {{ $items->links() }}
    </div>
@endsection
