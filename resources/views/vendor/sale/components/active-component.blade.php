@if($items->count() > 0)
    <section class="promotion">
        <div class="promotion__container container">
            <h2 class="promotion-heading">
                <a href="{{ route('sale.index') }}">Акции</a>
            </h2>
            <div class="promotion-list swiper">
                <div class="promotion-wrapper swiper-wrapper">
                    @foreach($items as $item)
                        <div class="promotion-item swiper-slide">
                            <a href="{{ route('sale.show', $item->alias) }}" class="promotion-content">
                                <div class="news-item__img">
                                    @if($item->image())
                                        <img src="{{ asset($item->image()->getPreview()) }} " alt="">
                                    @else
                                        <img src="{{ asset('img/new.png') }}" alt="">
                                    @endif
                                </div>
                                <div class="promotion-text">
                                    <div class="promotion-text__title">{{ $item->title }}</div>
                                    <div class="promotion-text__subtitle">{{ $item->getShortText() }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
