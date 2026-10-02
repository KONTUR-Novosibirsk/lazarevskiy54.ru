<?php

namespace Modules\Feedback\App\Models;

use Database\Factories\FeedbackFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Kontur\Dashboard\App\Rules\GoogleRecaptcha;
use Modules\Feedback\App\Events\FeedbackCreated;
use Modules\Feedback\App\Feedback\FeedbackConfigFactory;
use Modules\Feedback\App\Mail\FeedbackNotification;

class Feedback extends Model
{
    use HasFactory;

    private array $config = [];

    protected $casts = [
        'data' => 'array',
    ];

    protected $fillable = [
        'name',
        'status',
        'data',
    ];

    protected $dispatchesEvents = [
        'created' => FeedbackCreated::class,
    ];

    protected static function newFactory(): FeedbackFactory
    {
        return FeedbackFactory::new();
    }

    /*    protected static function booted(): void
        {
            static::created(function (Feedback $feedback) {
                if (settings('email')) {
                    Mail::to(settings('email'))->send(new FeedbackNotification($feedback));
                }
            });
        }*/

    public function prepareConfig(string $name, ?array $config = null)
    {
        $configFactory = app(FeedbackConfigFactory::class);
        $this->config = $configFactory->getConfig($name);
    }

    public function setConfig(array $config): static
    {
        $this->config = $config;
        return $this;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getRules(): array
    {
        $rules['g_recaptcha_token'] = ['required', new GoogleRecaptcha('feedback')];
        foreach ($this->config['form'] as $key => $formItem) {
            $rules[$key] = $formItem['rules'];
        }

        return $rules ?? [];
    }
}
