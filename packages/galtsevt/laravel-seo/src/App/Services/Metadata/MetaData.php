<?php

namespace Galtsevt\LaravelSeo\App\Services\Metadata;

use Galtsevt\LaravelSeo\App\Models\Seo;
use Illuminate\Database\Eloquent\Model;

class MetaData
{
    protected ?string $title = null;
    protected ?Seo $seo;
    protected ?Model $model = null;

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->seo?->title ?? $this->title;
    }

    public function getH1(): ?string
    {
        return $this->seo?->h1 ?? null;
    }

    public function getKeywords(): ?string
    {
        return $this->seo?->keywords ?? null;
    }

    public function getDescription(): ?string
    {
        return $this->seo?->description ?? null;
    }

    public function prepare(Model|array|null $seo): static
    {
        if (is_array($seo)) {
            $this->seo = new Seo($seo);
        } else {
            $this->model = $seo;
            if ($seo) {
                $this->seo = $seo->seo;
            }
        }

        return $this;
    }

    public function withTemplate(): void
    {
        if (!$this->seo && $this->model) {
            if ($seo = Seo::query()->where('model_type', get_class($this->model))->first()) {
                $this->seo = $seo;
                $seo->title = $this->addAttributes($seo->title);
                $seo->h1 = $this->addAttributes($seo->h1);
                $seo->keywords = $this->addAttributes($seo->keywords);
                $seo->description = $this->addAttributes($seo->description);
            }
        }
    }

    private function addAttributes(string $template): string
    {
        $model = $this->model;
        return preg_replace_callback('~(\{[a-z]+\})~ui', function ($matches) use ($model) {
            $match = str_replace(['{', '}'], '', $matches[0]);
            try {
                return $model->$match ?? null;
            } catch (\Exception $ex) {
                return 'undefined';
            }
        }, $template);
    }
}
