@extends('layouts.other')
@section('content')
    <section class="gallery">
        <div class="gallery-container container">
            <h1>{{ seo()->metaData()->getH1() ?? settings('name', 'gallery', 'Галерея') }}</h1>
            <div class="gallery-list">
                @foreach($galleries as $gallery)
                    <a href="{{ route('gallery.show', $gallery->alias) }}" class="gallery-item">
                        <div class="gallery-item__img">
                            @if($gallery->image)
                                <img src="{{ asset($gallery->image->getFull()) }} " alt="">
                            @else
                                <img src="{{ asset('img/new.png') }}" alt="">
                            @endif
                        </div>
                        <div class="gallery-item__title">
                            {{ $gallery->name }}
                        </div>
                        <div class="gallery-item__photo">
                            {{ $gallery->images_count }} фото
                        </div>
                    </a>
                @endforeach
            </div>
            {{ $galleries->links() }}
        </div>
    </section>
@endsection
