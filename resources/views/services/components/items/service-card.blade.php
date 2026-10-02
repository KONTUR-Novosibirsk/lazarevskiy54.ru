<a href="{{ $service->getUrl() }}">
    {{ $service->name }}
    <x-ui.image :image="$service->preview()" :alt="$service->name"/>
    @if($service->price)
        <span class="price">{{ $service->price }} ₽</span>
    @endif
</a>
