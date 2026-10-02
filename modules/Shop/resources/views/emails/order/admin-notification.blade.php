<x-mail::message>
# Новый заказ на сайте {{ settings('site_name') }}

<div class=""><b>Имя</b>: {{ $order->user_name }}</div>
<div class=""><b>Email</b>: {{ $order->user_email }}</div>
<div class=""><b>Телефон</b>: {{ $order->user_phone }}</div>

<x-mail::table>
| Название | Цена | Количество | Итого |
|:--------:| ----:| ----------:| --------:|
@foreach($order->products as $product)
| {{ $product->title }} | {{ $product->pivot->price }} руб. | {{ $product->pivot->count }} | {{ $product->pivot->count * $product->pivot->price }} руб. |
@endforeach
| | | Итого | {{ $order->price }} руб. |
</x-mail::table>

<x-mail::button url="{{ route('admin.shop.order.show', $order->id) }}">
    Детали
</x-mail::button>
    С уважением, {{ settings('site_name') }}
</x-mail::message>
