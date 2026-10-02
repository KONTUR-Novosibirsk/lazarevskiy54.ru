@if($items)
    <ul class="{{ $parentCss }}">
        @foreach($items as $item)
            <li class="{{ $item->children->count() > 0 ? 'has-sub-menu':''}}">
                <a class="{{ $item->isActive() ? 'active':'' }}" href="{{ $item->link() }}">{{ $item->name }}</a>
                @if($item->children->count() > 0)
                    <span class="sub-menu__arrow">
                       <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.9996 5.3285L7.99963 10.2035L2.99962 5.3285C2.90596 5.23484 2.79662 5.188 2.67162 5.188C2.54662 5.188 2.43729 5.23484 2.34363 5.3285C2.24996 5.42217 2.20312 5.5315 2.20312 5.6565C2.20312 5.7815 2.24479 5.88567 2.32812 5.969L7.65613 11.1565C7.74979 11.2502 7.86446 11.297 8.00012 11.297C8.13579 11.297 8.25046 11.2502 8.34412 11.1565L13.6721 5.9845C13.7555 5.89084 13.7971 5.77883 13.7971 5.6485C13.7971 5.51817 13.7503 5.40884 13.6566 5.3205C13.563 5.23217 13.4536 5.18784 13.3286 5.1875C13.2036 5.18717 13.0943 5.234 13.0006 5.328L12.9996 5.3285Z" fill="white"/>
                        </svg>
                    </span>
                    <x-menu::nested-menu-component :items="$item->children"/>
                @endif
            </li>
        @endforeach
    </ul>
@endif

