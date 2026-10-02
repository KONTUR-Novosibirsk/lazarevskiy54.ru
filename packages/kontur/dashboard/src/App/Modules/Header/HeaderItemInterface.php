<?php

namespace Kontur\Dashboard\App\Modules\Header;

interface HeaderItemInterface
{
    public function getName(): string;

    public function getData(): array;
}
