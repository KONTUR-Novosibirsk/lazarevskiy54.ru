<?php

namespace Modules\Slider\App\Services;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Slider\App\Models\{Slide, Slider};
use Modules\Slider\App\Requests\Slide\{SortRequest, StoreRequest, UpdateRequest};
use Modules\Slider\App\Resources\SlideResource;

class SlideService
{

    public function store(StoreRequest $request, Slider $slider): SlideResource
    {
        $slide = new Slide($request->validated());
        $slide->props = $this->validateProps($request, $slider);
        $slide->slider_id = $slider->id;
        $slide->save();
        return new SlideResource($slide);
    }

    public function update(UpdateRequest $request, Slide $slide): SlideResource
    {
        $slide->props = $this->validateProps($request, $slide->slider);
        $slide->update($request->validated());
        return new SlideResource($slide);
    }

    protected function validateProps(FormRequest $request, Slider $slider): ?array
    {
        if (!$slider->props) return null;
        $validateRules = new PropsValidateRules();

        foreach ($slider->props as $prop) {
            $rules['props.' . $prop['key']] = match ($prop['type']) {
                'input' => $validateRules->input(),
                'textarea' => $validateRules->textarea(),
                'checkbox' => $validateRules->checkbox(),
            };
        }

        $data = $request->validate($rules);
        return $data['props'] ?? null;
    }

    public function sort(SortRequest $request): bool
    {
        $data = $request->validated();
        $ids = collect($data)->pluck('id');
        $elements = Slide::query()
            ->select('id', 'sort')
            ->whereIn('id', $ids->toArray())
            ->orderByRaw('FIELD(id, ' . implode(',', $ids->toArray()) . ')')
            ->orderBy('sort')
            ->get();
        $sort = 1;
        foreach ($elements as $element) {
            $element->sort = $sort;
            $element->save();
            $sort++;
        }
        return true;
    }

}
