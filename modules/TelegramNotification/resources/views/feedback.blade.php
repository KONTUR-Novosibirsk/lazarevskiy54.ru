<b># Новое обращение на сайте {{ settings('site_name') }}</b>

Данные из формы:
@foreach($labels as $key => $item)
  <b>{{ $item['label'] }}</b>: {{ $feedback->data[$key] }}
@endforeach

<a href="{{ route('admin.feedback.show', $feedback->name) }}">Подробнее</a>
