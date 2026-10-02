@extends('layouts.other')
@section('content')
    <section class="news">
        <div class="news-container container">
            <h1>{{ seo()->metaData()->getH1() ?? settings('name', 'news', 'Новости') }}</h1>
            <div class="news-list">
                @foreach($news as $item)
                    @include('news::partial.news', ['news' => $item])
                @endforeach
            </div>
            {{ $news->links() }}
        </div>
    </section>
@endsection
