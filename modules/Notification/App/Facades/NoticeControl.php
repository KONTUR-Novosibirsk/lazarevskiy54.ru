<?php

namespace Modules\Notification\App\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Notification\App\Interfaces\Notice;
use Modules\Notification\App\Services\NoticeContainer;

/**
 * @method static NoticeContainer add(Notice $notice)
 * @method static array getAll()
 * @method static int count()
 *
 * @see NoticeContainer
 *
 **/
class NoticeControl extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'app.notification.notice';
    }
}
