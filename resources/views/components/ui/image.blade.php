<img src="{{ $image ? $image->getPreview() : asset('img/new.png') }}"
     alt="{{ $alt ?? '' }}"
     loading="lazy"
>
