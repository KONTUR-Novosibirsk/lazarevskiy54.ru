@extends('layouts.other')

@section('content')
    <section class="products">
        <div class="products-container container">
            <div class="products-head">
                <h1>{{ seo()->metaData()->getH1() ?? 'Хиты продаж' }}</h1>
            </div>
            <div class="products-content">
                <div class="products-content_left">
                    @if($categories->count() > 0)
                        <div class="products-menu">
                            <ul>
                                @foreach($categories as $childCategory)
                                    <li>
                                        <a href="{{ $childCategory->createUrl() }}">{{ $childCategory->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="products-content_right">
                    <div class="products-list">
                        @forelse($products as $product)
                            @include('shop::partial.product_card', ['product' => $product])
                        @empty
                            <div class="">Товары отсутствуют</div>
                        @endforelse
                    </div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>


@endsection
