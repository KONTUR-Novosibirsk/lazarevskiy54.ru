<?php

namespace Modules\Feedback\App\Services;

use Modules\Feedback\App\Feedback\FeedbackConfigFactory;
use Modules\Notification\App\Interfaces\Notice;

class FeedbackNotice implements Notice
{
    public function __construct(
        private readonly string $name,
        private readonly string $key,
    )
    {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRoute(): string
    {
        return route('admin.feedback.show', $this->key);
    }

    public function getCount(): int
    {
        $configFactory = app(FeedbackConfigFactory::class);
        return $configFactory->getCount($this->key);
    }
}
