<?php

namespace Modules\Notification\App\Services;

use Modules\Notification\App\Interfaces\Notice;

class NoticeContainer
{
    private array $container = [];

    public function add(Notice $notice): static
    {
        $this->container[] = $notice;
        return $this;
    }

    public function getAll(): array
    {
        return $this->container;
    }

    public function count(): int
    {
        $count = 0;
        foreach ($this->container as $notice) {
            $count += $notice->getCount();
        }
        return $count;
    }
}
