@extends('layouts.other')

@section('content')
    <section class="products">
        <div class="products-container container">
            <div class="products-head">
                <h1>{{ seo()->metaData()->getH1() ?? $category->title }}</h1>
                <a href="#" data-src="#filter-mobile" data-auto-focus="false" data-fancybox
                   class="products-filter__btn_mobile" data-options='{"touch" : false}'>Фильтр</a>
            </div>
            <div class="products-content">
                <div class="products-content_left">
                    @if($category->children->count() > 0)
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
                    <div class="products-filter">
                        <div class="products-filter__head">
                            <div class="products-filter__heading">Фильтр</div>
                            <div class="products-filter-item__arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                     fill="none">
                                    <path d="M15.8346 7.4987L10.0013 13.332L4.16797 7.4987" stroke="#374151"
                                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                        @if($filterableAttributes)
                            <div class="products-filter__body vue_app">
                                <product-filter-component url="{{ url()->current() }}"
                                                          :filterable-attributes="{{ $filterableAttributes?->toJson() }}"
                                                          :data="{{ json_encode($filterData) }}"></product-filter-component>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="products-content_right">
                    <div class="vue_app">
                        <product-sorter-component url="{{ url()->current() }}" :data="{{ json_encode($filterData) }}"
                                                  :attributes="{{ json_encode($sortAttributes) }}"></product-sorter-component>
                    </div>
                    <div class="js-filter-products">
                        @include('shop::partial.products')
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
