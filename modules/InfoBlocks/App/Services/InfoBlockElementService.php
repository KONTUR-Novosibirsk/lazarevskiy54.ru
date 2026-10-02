<?php

namespace Modules\InfoBlocks\App\Services;

use Illuminate\Foundation\Http\FormRequest;
use Modules\InfoBlocks\App\Models\{InfoBlock, InfoBlockElement};
use Modules\InfoBlocks\App\Requests\Element\{SortRequest, StoreRequest, UpdateRequest};

class InfoBlockElementService
{

    public function store(StoreRequest $request, InfoBlock $infoBlock): InfoBlockElement
    {
        $data = $request->validated();
        $data['props'] = $this->validateProps($request, $infoBlock);
        $infoBlockElement = new InfoBlockElement($data);
        $infoBlockElement->info_block_id = $infoBlock->id;
        $infoBlockElement->save();
        $request->session()->flash('success', 'Запись создана');
        return $infoBlockElement;
    }

    public function update(UpdateRequest $request, InfoBlockElement $infoBlockElement): InfoBlockElement
    {
        $data = $request->validated();
        $data['props'] = $this->validateProps($request, $infoBlockElement->parent);
        $infoBlockElement->update($data);
        return $infoBlockElement;
    }

    protected function validateProps(FormRequest $request, InfoBlock $infoBlock): ?array
    {
        if (!$infoBlock->props) return null;
        $validateRules = new PropsValidateRules();

        foreach ($infoBlock->props as $prop) {
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
        $elements = InfoBlockElement::query()
            ->select('id', 'sort')
            ->whereIn('id', $ids->toArray())
            ->orderByRaw('FIELD(id, ' . implode(',', $ids->toArray()) . ')')->get();
        $sort = 1;
        foreach ($elements as $element) {
            $element->sort = $sort;
            $element->save();
            $sort++;
        }
        return true;
    }

}
