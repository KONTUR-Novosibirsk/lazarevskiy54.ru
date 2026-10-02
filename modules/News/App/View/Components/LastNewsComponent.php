<?php

namespace Modules\News\App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\News\App\Models\News;

class LastNewsComponent extends Component
{
    protected int $limit;

    /**
     * Create a new component instance.
     */
    public function __construct(int $limit = 5)
    {
        $this->limit = $limit;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('news::components.last-news-component', [
            'news' => News::query()->active()->with('images')->orderBy('sort')->limit($this->limit)->get(),
        ]);
    }
}
