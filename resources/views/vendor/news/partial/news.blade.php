<a href="{{ route('news.show', $news->alias) }}" class="news-item">
    <div class="news-item__img">
        @if($news->image())
            <img src="{{ asset($news->image()->getPreview()) }} " alt="">
        @else
            <img src="{{ asset('img/new.png') }}" alt="">
        @endif
    </div>
    <div class="news-item__content">
        <div class="news-item__text">
            {{ $news->title }}
        </div>
        <div class="news-item__date">
            {{ $item->publication_date->format('d.m.Y') }}
        </div>
    </div>
</a>
