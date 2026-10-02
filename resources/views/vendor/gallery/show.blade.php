@extends('layouts.other')
@section('content')
    <section class="album">
        <div class="album-container container">
            <h1>{{ seo()->metaData()->getH1() ?? $gallery->name }}</h1>
            <div class="album-content">
                @foreach($galleryImages as $galleryImage)
                    <a href="{{ $galleryImage->image()?->getFull() }}" class="album-item" data-fancybox="first_gallery">
                        <img src="{{ $galleryImage->image()?->getPreview()  }}" alt="">
                    </a>
                @endforeach
            </div>
            {{ $galleryImages->links() }}
        </div>
    </section>
@endsection
