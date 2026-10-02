@extends('layouts.app')
@section('app.content')
    <section class="banner" style="background: no-repeat center/cover url('{{ iblock()->getById(1)?->elements[0]?->image()?->getFull() }}')">
        <div class="container">
            <div class="banner__content">
                {!! iblock()->getById(1)?->elements[0]?->description !!}
                <a href="/shop" class="btn">Перейти в каталог</a>
            </div>
        </div>
    </section>
    @module('services')
        <x-services::homepage-services/>
    @endmodule
    @module('slider')
    <section class="main-slider">
        <x-slider::slider-component code="main"/>
    </section>
    @endmodule
    @module('shop')
    <x-shop::hit-products limit="10"/>
    <x-shop::categories-on-index limit="10"/>
    @endmodule
    @module('sale')
    <x-sale::active-component limit="5"/>
    @endmodule
    <section class="about">
        <div class="about__container container">
            <h2 class="about-heading">
                <a href="#">{{ iblock()->getById(1)?->title }}</a>
            </h2>
            <div class="about-content">
                {!! iblock()->getById(1)?->description !!}
            </div>
        </div>
    </section>

    <div id="cookieee">
        <form method="POST" action="{{ route('cookie.accept') }}">
            @csrf
            @method('POST')
            <p>Мы используем cookie-файлы
                <a href="{{ route('page.show', settings('policy_page', default: 1)) }}">
                    подробнее
                </a>.
            </p>
            <input type="hidden" name="accepted_all" value="1">
            <button type="submit" id="cookieee__apply">Принять</button>
        </form>
    </div>


    <section class="brands">
        <div class="brands__container container">
            <h2 class="brands-heading">
                <a href="#">
                    Бренды
                </a>
            </h2>
            <div class="brands-list swiper">
                <div class="brands-list__wrapper swiper-wrapper">
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                    <div class="brands-item swiper-slide">
                        <img src="images/brand__img.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="advantages">
        <div class="advantages__container container">
            <h2 class="advantages-heading">
                Наши преимущества
            </h2>
            <div class="advantages-list">
                <div class="advantages-item">
                    <div class="advantages-item__ico">
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="25" cy="25" r="25" fill="#D1D5DB"/>
                            <path
                                d="M13 31L19.879 24.121C20.4416 23.5586 21.2045 23.2426 22 23.2426C22.7955 23.2426 23.5584 23.5586 24.121 24.121L31 31M28 28L30.379 25.621C30.9416 25.0586 31.7045 24.7426 32.5 24.7426C33.2955 24.7426 34.0584 25.0586 34.621 25.621L37 28M28 19H28.015M16 37H34C34.7956 37 35.5587 36.6839 36.1213 36.1213C36.6839 35.5587 37 34.7956 37 34V16C37 15.2044 36.6839 14.4413 36.1213 13.8787C35.5587 13.3161 34.7956 13 34 13H16C15.2044 13 14.4413 13.3161 13.8787 13.8787C13.3161 14.4413 13 15.2044 13 16V34C13 34.7956 13.3161 35.5587 13.8787 36.1213C14.4413 36.6839 15.2044 37 16 37Z"
                                stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="advantages-item__text">
                        Бонусные рубли за покупки
                    </div>
                </div>
                <div class="advantages-item">
                    <div class="advantages-item__ico">
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="25" cy="25" r="25" fill="#D1D5DB"/>
                            <path
                                d="M13 31L19.879 24.121C20.4416 23.5586 21.2045 23.2426 22 23.2426C22.7955 23.2426 23.5584 23.5586 24.121 24.121L31 31M28 28L30.379 25.621C30.9416 25.0586 31.7045 24.7426 32.5 24.7426C33.2955 24.7426 34.0584 25.0586 34.621 25.621L37 28M28 19H28.015M16 37H34C34.7956 37 35.5587 36.6839 36.1213 36.1213C36.6839 35.5587 37 34.7956 37 34V16C37 15.2044 36.6839 14.4413 36.1213 13.8787C35.5587 13.3161 34.7956 13 34 13H16C15.2044 13 14.4413 13.3161 13.8787 13.8787C13.3161 14.4413 13 15.2044 13 16V34C13 34.7956 13.3161 35.5587 13.8787 36.1213C14.4413 36.6839 15.2044 37 16 37Z"
                                stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="advantages-item__text">
                        Бонусные рубли за покупки
                    </div>
                </div>
                <div class="advantages-item">
                    <div class="advantages-item__ico">
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="25" cy="25" r="25" fill="#D1D5DB"/>
                            <path
                                d="M13 31L19.879 24.121C20.4416 23.5586 21.2045 23.2426 22 23.2426C22.7955 23.2426 23.5584 23.5586 24.121 24.121L31 31M28 28L30.379 25.621C30.9416 25.0586 31.7045 24.7426 32.5 24.7426C33.2955 24.7426 34.0584 25.0586 34.621 25.621L37 28M28 19H28.015M16 37H34C34.7956 37 35.5587 36.6839 36.1213 36.1213C36.6839 35.5587 37 34.7956 37 34V16C37 15.2044 36.6839 14.4413 36.1213 13.8787C35.5587 13.3161 34.7956 13 34 13H16C15.2044 13 14.4413 13.3161 13.8787 13.8787C13.3161 14.4413 13 15.2044 13 16V34C13 34.7956 13.3161 35.5587 13.8787 36.1213C14.4413 36.6839 15.2044 37 16 37Z"
                                stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="advantages-item__text">
                        Бонусные рубли за покупки
                    </div>
                </div>
                <div class="advantages-item">
                    <div class="advantages-item__ico">
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="25" cy="25" r="25" fill="#D1D5DB"/>
                            <path
                                d="M13 31L19.879 24.121C20.4416 23.5586 21.2045 23.2426 22 23.2426C22.7955 23.2426 23.5584 23.5586 24.121 24.121L31 31M28 28L30.379 25.621C30.9416 25.0586 31.7045 24.7426 32.5 24.7426C33.2955 24.7426 34.0584 25.0586 34.621 25.621L37 28M28 19H28.015M16 37H34C34.7956 37 35.5587 36.6839 36.1213 36.1213C36.6839 35.5587 37 34.7956 37 34V16C37 15.2044 36.6839 14.4413 36.1213 13.8787C35.5587 13.3161 34.7956 13 34 13H16C15.2044 13 14.4413 13.3161 13.8787 13.8787C13.3161 14.4413 13 15.2044 13 16V34C13 34.7956 13.3161 35.5587 13.8787 36.1213C14.4413 36.6839 15.2044 37 16 37Z"
                                stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="advantages-item__text">
                        Бонусные рубли за покупки
                    </div>
                </div>
            </div>
        </div>
    </section>
    @module('news')
    <section class="news">
        <x-news::last-news-component limit="4"/>
    </section>
    @endmodule
@endsection
