@extends('layouts.other')
@section('content')
    <section class="search">
        <div class="search-container container">
            <h1>{{ seo()->metaData()->getH1() ?? 'Поиск' }}</h1>
            @if($products->count() == 0)
                <div class="search-head">По вашему запросу ничего не найдено</div>
            @else
                <div class="search-head">По вашему запросу "{{ $search }}" найдено следующее:</div>
                <div class="search-content-products">
                    @foreach($products as $product)
                        @include('shop::partial.product_card', ['product' => $product])
                    @endforeach
                </div>
                {{ $products->links() }}
            @endif
        </div>
    </section>
@endsection
