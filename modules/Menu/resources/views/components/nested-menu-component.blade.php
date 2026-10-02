@if($items)
    <ul class="sub-menu">
        @foreach($items as $item)
            <li>
                <a href="{{ $item->link() }}"> {{ $item->name }} </a>
                @if($item->children->count() > 0)
                    <x-menu::nested-menu-component :items="$item->children"/>
                @endif
            </li>
        @endforeach
    </ul>
@endif
