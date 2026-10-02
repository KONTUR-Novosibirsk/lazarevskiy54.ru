@if($product->price > 0)
    @if($type == 'link')
        <a data-product="{{ $product->jsonDataForCartButton() }}" class="{{ $css }} js__add_to_cart">
            {{ $text ?? 'В корзину' }}
        </a>
    @else
        <button data-product="{{ $product->jsonDataForCartButton() }}" class="{{ $css }} js__add_to_cart">
            {{ $text ?? 'В корзину' }}
        </button>
    @endif
@else
    Нет в наличии
@endif
