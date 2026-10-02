<li class="">
    <a href="{{ $service->getUrl() }}">
        {{ $service->name }}
        @if($service->price)
            <span class="price">{{ $service->price }} ₽</span>
        @endif
    </a>

    @if ($depth > 1 && ($children = $service->activeChildren)?->isNotEmpty())
        <ul class="">
            @foreach ($children as $child)
                <x-services::items.service-list-item :service="$child" :depth="$depth - 1"/>
            @endforeach
        </ul>
    @endif

</li>
