@if(count($breadcrumbs) > 0)
    <div class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
        <div itemprop="itemListElement" itemscope
             itemtype="https://schema.org/ListItem"
             class="breadcrumbs-item">
            <a itemprop="item" href="{{ route('index') }}">
                <span itemprop="name">Главная</span>
            </a>
            <meta itemprop="position" content="1"/>
        </div>
        @foreach($breadcrumbs as $item)
            <div class="breadcrumbs-item"
                 itemprop="itemListElement" itemscope
                 itemtype="https://schema.org/ListItem">
                @if($loop->last or is_numeric($item->getUrl()))
                    <span itemprop="name"> {{ $item->getName() }} </span>
                @else
                    <a itemscope itemtype="https://schema.org/WebPage"
                       itemprop="item"
                       itemid="{{ $item->getUrl() }}"
                       href="{{ $item->getUrl() }}">
                        <span itemprop="name"> {{ $item->getName() }} </span>
                    </a>
                @endif
                <meta itemprop="position" content="{{ ++$loop->iteration }}"/>
            </div>
        @endforeach
    </div>
@endif

