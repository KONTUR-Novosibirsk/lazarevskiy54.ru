@if($categories->count() > 0)
    <section class="categories">
        <div class="categories__container container">
            <h2 class="categories-heading">
                <a href="{{ route('shop.index') }}">Категории</a>
            </h2>
            <div class="categories-list">
                @foreach($categories as $category)
                    <div class="categories-item">
                        <a href="{{ $category->createUrl() }}" class="categories-item__img">
                            @if($category->image()?->getPreview())
                                <img src="{{ $category->image()?->getPreview() }} " alt="">
                            @else
                                <img src="{{ asset('img/new.png') }}" alt="">
                            @endif
                        </a>
                        <div class="categories-item__content">
                            <div class="categories-item__title">
                                <a href="{{ $category->createUrl() }}">
                                    {{ $category->title }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
