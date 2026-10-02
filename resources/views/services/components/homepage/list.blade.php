@if ($services->count() > 0)
    <section class="">
        <div class="container">
            <h1>
                <a href="{{ route('services.index') }}">
                    {{ $title }}
                </a>
            </h1>
            {!! $content !!}
            <ul class="">
                @foreach($services as $service)
                    <x-services::items.service-list-item :service="$service" :depth="$depth"/>
                @endforeach
            </ul>
        </div>
    </section>
@endif
