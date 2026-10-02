@if ($services->count() > 0)
    <section class="">
        <div class="container">
            <h1>
                <a href="{{ route('services.index') }}">
                    {{ $title }}
                </a>
            </h1>
            {!! $content !!}
            @foreach($services as $service)
                <x-services::items.service-card :service="$service"/>
            @endforeach
        </div>
    </section>
@endif
