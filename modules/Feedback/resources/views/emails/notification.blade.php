<x-mail::message>
# Новое обращение на сайте {{ settings('site_name') }}

Поля из формы:
    @foreach($labels as $key => $item)
       <div class="">
           <b>{{ $item['label'] }}</b>: {{ $feedback->data[$key] }}
       </div>
    @endforeach

<x-mail::button url="{{ route('admin.feedback.show', $feedback->name) }}">
В админ-панель
</x-mail::button>

С уважением,<br>
{{ settings('site_name') }}
</x-mail::message>
