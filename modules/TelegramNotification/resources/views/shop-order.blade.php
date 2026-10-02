<b># Новое заказ на сайте {{ settings('site_name') }}</b>

<b>Сумма заказа:</b> {{ $order->price }} {!! settings('currency', 'shop', '&#8381;') !!}

<a href="{{ route('admin.shop.order.show', $order->id) }}">Подробнее на сайте</a>
