<?php

namespace Modules\Slider\App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SliderComponent extends Component
{
    protected string $code;
    protected string $view;

    /**
     * Create a new component instance.
     */
    public function __construct(string $code, string $view = 'slider-component')
    {
        $this->code = $code;
        $this->view = $view;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($slider = \Modules\Slider\App\Models\Slider::query()
            ->with(['slides', 'slides.images'])->where('code', $this->code)->first()) {
            return view('slider::components.' . $this->view, [
                'slides' => $slider->slides,
            ]);
        }

        return false;
    }
}
