<?php

namespace Modules\Slider\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Slider\App\Models\Slider;
use Modules\Slider\App\Requests\Slider\{StoreRequest, UpdateRequest};
use Modules\Slider\App\Resources\{SlideResource, SliderResource};

class SliderController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Слайдеры', route('admin.slider.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle('Слайдеры');

        return inertia('Modules/Slider/Index', [
            'sliders' => SliderResource::collection(
                Slider::query()->orderBy('id', 'DESC')
                    ->paginate(settings('per_page_admin', default: 10)),
            )
        ]);
    }

    public function show(Slider $slider): \Inertia\Response
    {
        Seo::metaData()->setTitle($slider->name);
        Seo::breadcrumbs()->add($slider->name, route('admin.slider.show', $slider->id));
        Seo::breadcrumbs()->add('Слайды');
        return inertia('Modules/Slider/Show', [
            'slider' => new SliderResource($slider),
            'slides' => SlideResource::collection($slider->slides),
        ]);
    }

    public function store(StoreRequest $request): SliderResource
    {
        $slider = new Slider($request->validated());
        $slider->save();
        return new SliderResource($slider);
    }

    public function update(UpdateRequest $request, Slider $slider): SliderResource
    {
        $slider->update($request->validated());
        return new SliderResource($slider);
    }

    public function destroy(Slider $slider): \Illuminate\Http\RedirectResponse
    {
        $slider->delete();
        return redirect()->route('admin.slider.index');
    }
}
