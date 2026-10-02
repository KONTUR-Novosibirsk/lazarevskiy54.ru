<?php

namespace Modules\Feedback\App\Widgets;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Kontur\Dashboard\App\Modules\Widget\AbstractWidget;
use Modules\Feedback\App\Models\Feedback;

class FeedbackWidget extends AbstractWidget
{

    protected ?Collection $records = null;

    public function getId(): string
    {
        return 'FeedbackWidget';
    }

    public function getName(): string
    {
        return 'График обратная связь';
    }

    public function getData(): array
    {
        return [
            'month' => $this->getDataByDays(30),
            'two_week' => $this->getDataByDays(14),
            'week' => $this->getDataByDays(7),
        ];
    }

    public function getDescription(): string
    {
        return 'Количество обращений по дням';
    }

    protected function getDataByDays(int $days): array
    {
        foreach (CarbonPeriod::create(Carbon::now()->subDays($days), Carbon::now()) as $date) {
            $data['category'][] = $date->format('Y-m-d');
            $data['count'][] = $this->getRecords($days)->where('date', $date->format('Y-m-d'))->first()?->count ?? 0;
        }
        return $data ?? [];
    }

    protected function getRecords(int $days): Collection
    {
        return $this->records ??= Feedback::query()->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->groupBy('date')->orderBy('date')->get();
    }
}
