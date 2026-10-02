<?php

namespace Modules\Notification\App\Services;

use Kontur\Dashboard\App\Modules\Header\HeaderItemInterface;
use Modules\Notification\App\Facades\NoticeControl;
use Modules\Notification\App\Resources\NoticeResource;

class NotificationHeaderItem implements HeaderItemInterface
{
    public function getName(): string
    {
        return 'Notification';
    }

    public function getData(): array
    {
        return [
            'data' => NoticeResource::collection(NoticeControl::getAll()),
            'count' => NoticeControl::count(),
        ];
    }
}
