<div class="main-slider__container container">
    <div class="main-slider__content swiper">
        <div class="main-slider__wrapper swiper-wrapper">
            @foreach($slides as $slide)
            <div class="main-slider__item swiper-slide">
                <img src="{{ $slide->image()?->getFull() }}" alt="{{ $slide->title }}" loading="lazy">
            </div>
            @endforeach
        </div>
        <div class="main-slider__navigation">
            <div class="main-slider__prev">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="&#208;&#152;&#208;&#186;&#208;&#190;&#208;&#189;&#208;&#186;&#208;&#184;">
                        <path id="Vector" d="M24.9987 31.6693L13.332 20.0026L24.9987 8.33594" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
            </div>
            <div class="main-slider__next">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="&#208;&#152;&#208;&#186;&#208;&#190;&#208;&#189;&#208;&#186;&#208;&#184;">
                        <path id="Vector" d="M15.0013 8.33073L26.668 19.9974L15.0013 31.6641" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
            </div>
        </div>
        <div class="main-slider__pagination"></div>
    </div>
</div>
