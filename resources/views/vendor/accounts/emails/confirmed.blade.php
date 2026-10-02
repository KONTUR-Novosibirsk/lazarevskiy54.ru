<x-mail::message>
    Ваш аккаунт {{ $account->login }} подтвержден
    <x-mail::button url="{{ route('account.me') }}">
        В личный кабинет
    </x-mail::button>
    С уважением,<br>
    {{ settings('site_name', default: config('app.name')) }}
</x-mail::message>
