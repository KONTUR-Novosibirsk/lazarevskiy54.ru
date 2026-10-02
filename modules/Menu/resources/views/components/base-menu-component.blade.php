@if($items)
    <ul class="{{ $parentCss }}">
        @foreach($items as $item)
            <li class="{{ $item->children->count() > 0 ? 'has-sub-menu':''}}">
                <a class="{{ $item->isActive() ? 'active':'' }}" href="{{ $item->link() }}">{{ $item->name }}</a>
                @if($item->children->count() > 0)
                    <x-menu::nested-menu-component :items="$item->children"/>
                @endif
            </li>
        @endforeach
    </ul>
@endif

