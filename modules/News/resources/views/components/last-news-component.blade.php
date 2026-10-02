@if($news->count() > 0)
    <div class="news__container container">
        <h2 class="news-heading">
            <a href="{{ route('news.index') }}">Новости</a>
        </h2>
        <div class="news-list">
            @foreach($news as $item)
                <a href="{{ route('news.show', $item->alias) }}" class="news-item">
                    <div class="news-item__img">
                        @if($item->image())
                            <img src="{{ asset($item->image()->getPreview()) }} " alt="">
                        @else
                            <img src="{{ asset('img/new.png') }}" alt="">
                        @endif
                    </div>
                    <div class="news-item__content">
                        <div class="news-item__text">
                            {{ $item->title }}
                        </div>
                        <div class="news-item__date">
                            {{ $item->publication_date->format('d.m.Y') }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif

