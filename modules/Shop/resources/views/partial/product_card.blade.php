<div class="products-item {{ $cssClass ?? '' }}">
    <a href="{{ $product->createUrl($category ?? null) }}"
       class="products-item__img">
        @if($product->previewImages()?->first())
            <img src="{{ $product->previewImages()->first()->getPreview() }} " alt="">
        @else
            <img src="{{ asset('img/new.png') }}" alt="">
        @endif
    </a>
    <div class="products-item__content">
        <div class="products-item__price">
            <div class="products-item__price_new">
                {{ $product->price }} ₽
            </div>
            <div class="products-item__price_old">
                {{ $product->old_price }} ₽
            </div>
        </div>
        <div class="products-item__title">
            <a href="{{ $product->createUrl($category ?? null) }}">
                {{ $product->title }}
            </a>
        </div>
        <x-shop::add-to-cart :product="$product" css="products-item__btn" type="link"/>
    </div>
</div>
