@extends('layouts.other')

@section('content')

    <section class="product">
        <div class="product-container container">
            <h1 class="product-heading">{{ seo()->metaData()->getH1() ?? $product->title }}</h1>
            <div class="product-content">
                <div class="product-content__left">
                    <div class="product-slider_main swiper">
                        <div class="product-wrapper swiper-wrapper">
                            @foreach($product->previewImages() as $image)
                                <a href="{{ $image->getFull() }}" class="product-slide swiper-slide">
                                    <img src="{{ $image->getPreview() }}" alt="">
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @if($product->previewImages()->count() > 1)
                        <div class="product-slider__container">
                            <div class="product-prev">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="16" viewBox="0 0 21 16"
                                     fill="none">
                                    <path
                                        d="M0.292892 7.29289C-0.0976315 7.68342 -0.0976315 8.31658 0.292892 8.70711L6.65685 15.0711C7.04738 15.4616 7.68054 15.4616 8.07107 15.0711C8.46159 14.6805 8.46159 14.0474 8.07107 13.6569L2.41421 8L8.07107 2.34315C8.46159 1.95262 8.46159 1.31946 8.07107 0.928932C7.68054 0.538408 7.04738 0.538408 6.65685 0.928932L0.292892 7.29289ZM21 7L1 7V9H21V7Z"
                                        fill="#D1D5DB"/>
                                </svg>
                            </div>
                            <div class="product-slider_navigate swiper">
                                <div class="product-wrapper swiper-wrapper">
                                    @foreach($product->previewImages() as $image)
                                        <div class="product-slide swiper-slide">
                                            <img src="{{ $image->getPreview() }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="product-next">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="16" viewBox="0 0 21 16"
                                     fill="none">
                                    <path
                                        d="M20.7071 8.70711C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928932C13.9526 0.538408 13.3195 0.538408 12.9289 0.928932C12.5384 1.31946 12.5384 1.95262 12.9289 2.34315L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.70711ZM0 9L20 9V7L0 7L0 9Z"
                                        fill="#D1D5DB"/>
                                </svg>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="product-content__right">
                    <div class="product-price">
                        <div class="product-price_new">{{ $product->price }} ₽</div>
                        <div class="product-price_old">{{ $product->old_price }} ₽</div>
                    </div>
                    <!--                    <div class="product-offer product-offer_colors">
                                            <div class="product-offer__heading">Цвет</div>
                                            <div class="product-offer__body">
                                                <div class="product-offer__item">
                                                    <input type="radio" id="product-color" name="product-color">
                                                    <label for="product-color" style="background-color: #FFF">
                                                    </label>
                                                </div>
                                                <div class="product-offer__item">
                                                    <input type="radio" id="product-color1" name="product-color">
                                                    <label for="product-color1" style="background-color: #14834E">
                                                    </label>
                                                </div>
                                                <div class="product-offer__item">
                                                    <input type="radio" id="product-color2" name="product-color">
                                                    <label for="product-color2" style="background-color: #FF7676">
                                                    </label>
                                                </div>
                                                <div class="product-offer__item">
                                                    <input type="radio" id="product-color3" name="product-color">
                                                    <label for="product-color3" style="background-color: #144083">
                                                    </label>
                                                </div>
                                                <div class="product-offer__item">
                                                    <input type="radio" id="product-color4" name="product-color">
                                                    <label for="product-color4" style="background-color: #f3db04">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>-->

                    @if($tradeOfferAttributes)
                        @foreach($tradeOfferAttributes as $tradeOfferAttribute)
                            <div class="product-offer product-offer_sizes">
                                <div class="product-offer__heading">{{ $tradeOfferAttribute['name'] }}</div>
                                <div class="product-offer__body">
                                    @foreach($tradeOfferAttribute['attributes'] as $attributeValue)
                                        @if($attributeValue['product'])
                                            <a href="{{ $attributeValue['product']['url'] }}"
                                               title="{{ $attributeValue['product']['title'] }}"
                                               class="product-offer__item {{ $attributeValue['current'] ? 'active':'' }}">
                                                {{ $attributeValue['value'] }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <x-shop::add-to-cart :product="$product" css="product-btn" type="button" text="Добавить в корзину"/>
                </div>
                <div class="product-content__bottom">
                    <div class="product-tabs">
                        <div class="product-tabs__item" data-tab="description">Описание</div>
                        <div class="product-tabs__item" data-tab="characteristic">Характеристики</div>
                    </div>
                    <div class="product-description product-tabs__content" data-tab="description">
                        <div class="product-description__heading">
                            Описание
                        </div>
                        <div class="product-description__body">
                            {!! $product->description  !!}
                        </div>
                    </div>
                    @if(count($productAttributes = $product->attributes()) > 0)
                        <div class="product-characteristic product-tabs__content" data-tab="characteristic">
                            <div class="product-characteristic__heading">
                                Характеристики
                            </div>
                            <div class="product-characteristic__list">
                                <div class="product-characteristic__item">
                                    @foreach($product->attributes() as $attribute)
                                        <div class="product-characteristic__content">
                                            <div class="product-characteristic__left">{{ $attribute['name'] }}</div>
                                            <div class="product-characteristic__dotted"></div>
                                            <div class="product-characteristic__right">{{ $attribute['value'] }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @if($similarProducts->count() > 0)
        <section class="product-similar">
            <div class="product-similar__container container">
                <h2>Похожие товары</h2>
                <div class="product-similar__slider swiper">
                    <div class="product-similar__wrapper swiper-wrapper">
                        @foreach($similarProducts as $similarProduct)
                            @include('shop::partial.product_card', ['product' => $similarProduct, 'cssClass' => 'swiper-slide'])
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if($recentProducts->count() > 0)
        <section class="product-watched">
            <div class="product-watched__container container">
                <h2>Вы недавно смотрели</h2>
                <div class="product-watched__slider swiper">
                    <div class="product-watched__wrapper swiper-wrapper">
                        @foreach($recentProducts as $recentProduct)
                            @include('shop::partial.product_card', ['product' => $recentProduct, 'cssClass' => 'swiper-slide'])
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
