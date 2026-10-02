<?php

namespace Modules\Feedback\App\Services;

use Modules\Feedback\App\Feedback\FeedbackConfigFactory;
use Modules\Notification\App\Facades\NoticeControl;

class NoticeRegister
{
    public function __invoke(): void
    {
        $configFactory = app(FeedbackConfigFactory::class);
        foreach ($configFactory->getAllConfigs() as $config) {
            NoticeControl::add(
                new FeedbackNotice(
                    name: $config['title'],
                    key: $config['name'],
                )
            );
        }
    }
}
