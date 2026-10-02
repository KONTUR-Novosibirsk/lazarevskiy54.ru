<?php

namespace Modules\Notification\App\Interfaces;

interface Notice
{
    public function getName(): string;

    public function getRoute(): string;

    public function getCount(): int;
}
