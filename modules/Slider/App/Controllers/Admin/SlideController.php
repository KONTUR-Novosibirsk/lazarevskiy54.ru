<?php

namespace Modules\Slider\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Galtsevt\LaravelStorage\App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Storage\App\Resources\ImageResource;
use Modules\Slider\App\Models\{Slide, Slider};
use Modules\Slider\App\Requests\Slide\{SortRequest, StoreRequest, UpdateRequest};
use Modules\Slider\App\Resources\{SlideResource, SliderResource};
use Modules\Slider\App\Services\SlideService;

class SlideController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Слайдеры', route('admin.slider.index'));
    }

    public function create(Slider $slider): \Inertia\Response
    {
        Seo::breadcrumbs()->addList([
            route('admin.slider.show', $slider->id) => $slider->name,
            'Слайды',
            route('admin.slide.create', $slider->id) => 'Добавить'
        ]);
        Seo::metaData()->setTitle('Новый слайд');

        return inertia('Modules/Slider/Slide/Form', [
            'slider' => new SliderResource($slider),
            'model' => get_class($slide = new Slide()),
            'preview' => ($preview = Image::getFreeImages($slide, 'preview')?->first()) ?
                new ImageResource($preview) : null,
        ]);
    }

    public function store(StoreRequest $request, SlideService $service, Slider $slider): SlideResource
    {
        return $service->store($request, $slider);
    }

    public function edit(Slide $slide): \Inertia\Response
    {
        Seo::breadcrumbs()->addList([
            route('admin.slider.show', $slide->slider->id) => $slide->slider->name,
            route('admin.slide.edit', $slide->id) => $slide->title,
            'Изменить'
        ]);

        Seo::metaData()->setTitle($slide->title);

        return inertia('Modules/Slider/Slide/Form', [
            'slider' => new SliderResource($slide->slider),
            'slide' => new SlideResource($slide),
            'model' => get_class($slide),
        ]);
    }

    public function update(UpdateRequest $request, Slide $slide, SlideService $service): SlideResource
    {
        return $service->update($request, $slide);
    }

    public function destroy(Slide $slide): \Illuminate\Http\RedirectResponse
    {
        $slide->delete();
        return redirect()->back();
    }

    public function sort(SortRequest $request, SlideService $service): \Illuminate\Http\JsonResponse
    {
        return response()->json($service->sort($request));
    }

    /**
     * Обновление сортировки слайда
     *
     * @param Request $request
     * @param Slide $slide
     * @return JsonResponse
     */
    public function updateSort(Request $request, Slide $slide): JsonResponse
    {
        $slide['sort'] = $request->input(key: 'sort');
        $slide->save();

        return response()->json(['success' => true]);
    }
}
