@if($products->count() > 0)
    <section class="hit">
        <div class="hit__container container">
            <h2 class="hit-heading">
                <a href="{{ route('shop.hit-products') }}">
                    Хиты продаж
                </a>
            </h2>
            <div class="hit-list">
                @foreach($products as $product)
                    <div class="hit-item">
                        <a href="{{ $product->category->createUrl() }}/product/{{ $product->alias }}"
                           class="hit-item__img">
                            @if($product->previewImages()?->first())
                                <img src="{{ $product->previewImages()->first()->getPreview() }} " alt="">
                            @else
                                <img src="{{ asset('img/new.png') }}" alt="">
                            @endif
                        </a>
                        <div class="hit-item__content">
                            <div class="hit-item__price">
                                <div class="hit-item__price_new">
                                    {{ $product->price }} ₽
                                </div>
                                <div class="hit-item__price_old">
                                    {{ $product->old_price }} ₽
                                </div>
                            </div>
                            <div class="hit-item__title">
                                <a href="{{ $product->category->createUrl() }}/product/{{ $product->alias }}">
                                    {{ $product->title }}
                                </a>
                            </div>
                            <x-shop::add-to-cart css="hit-item__btn" :product="$product" type="link"/>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($products->count() > 5)
                <div class="hit-list__more">Показать ещё</div>
            @endif
        </div>
    </section>
@endif
