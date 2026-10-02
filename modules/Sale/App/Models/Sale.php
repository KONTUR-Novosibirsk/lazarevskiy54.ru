<?php

namespace Modules\Sale\App\Models;

use App\Models\BaseModel;
use Galtsevt\LaravelSeo\App\Interfaces\SitemapContract;
use Galtsevt\LaravelSeo\App\Traits\HasSeo;
use Galtsevt\LaravelStorage\App\Interfaces\Imageable;
use Galtsevt\LaravelStorage\App\Traits\HasImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Sale extends BaseModel implements Imageable, SitemapContract
{
    use HasFactory, HasSeo, HasImages;

    protected $table = 'sale';

    protected $guarded = false;

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function image()
    {
        return $this->getImagesByGroup('preview')?->first();
    }

    public function imageGroups(): array
    {
        return [
            'preview' => [
                'single' => true,
            ],
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->where([
            ['start_date', '<=', Carbon::now()],
            ['end_date', '>=', Carbon::now()],
        ]);
    }

    public function isActive(): bool
    {
        return $this->start_date < Carbon::now() and $this->end_date >= Carbon::now();
    }

    public function getUrl(): string
    {
        return route('sale.show', $this->alias);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%');
        })->when(isset($filters['active']) && in_array($filters['active'], [0, 1]), function ($query, $active) use ($filters) {
            if ($filters['active'] == 1) {
                $query->where([
                    ['start_date', '<=', Carbon::now()],
                    ['end_date', '>=', Carbon::now()],
                ]);
            } else {
                $query->where('start_date', '>=', Carbon::now())->orWhere('end_date', '<=', Carbon::now());
            }
        });
    }

    public function getShortText(): string
    {
        return mb_strimwidth(strip_tags($this->text), 0, 120, '...');
    }

    public function getSitemapUrl(): string
    {
        return route('sale.show', $this->alias);
    }

    public function getSitemapDate(): string
    {
        return $this->updated_at->format('Y-m-d\TH:i:sP');
    }

}
