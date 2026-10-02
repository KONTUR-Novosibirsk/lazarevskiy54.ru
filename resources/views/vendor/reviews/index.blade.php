@extends('layouts.other')
@section('content')
    <section class="faq">
        <div class="faq-container container">
            <div class="faq-head">
                <h1>{{ seo()->metaData()->getH1() ?? settings('name', 'reviews', 'Отзывы') }}</h1>
                <a href="#" class="faq-btn" data-src="#review-popup" data-auto-focus="false" data-fancybox>
                    Оставить отзыв
                </a>
            </div>
            <div class="faq-content">
                @forelse($reviews as $review)
                    <div class="faq-item question">
                        <div class="faq-item__text">
                            <div class="faq-item__title">
                                {{ $review->name }}
                            </div>
                            <div class="faq-item__description">
                                {!! $review->text !!}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="">Записи отсутствуют</div>
                @endforelse
            </div>
            {{ $reviews->links() }}
        </div>
    </section>
    <div id="review-popup" style="display: none;" class="vue_app">
        <review-form-component
            privacy-policy-link="{{ route('page.show', settings('policy_page', default: 1)) }}"></review-form-component>
    </div>
@endsection
