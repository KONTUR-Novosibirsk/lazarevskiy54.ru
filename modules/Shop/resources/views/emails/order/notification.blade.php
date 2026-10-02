<x-mail::message>
# Заказ на сайте {{ settings('site_name') }}

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

С уважением, администрация {{ settings('site_name') }}
</x-mail::message>
