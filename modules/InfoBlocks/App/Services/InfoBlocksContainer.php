<?php

namespace Modules\InfoBlocks\App\Services;

use Illuminate\Support\Collection;
use Modules\InfoBlocks\App\Models\InfoBlock;

class InfoBlocksContainer
{
    protected Collection $infoBlocks;

    public function __construct()
    {
        $this->infoBlocks = collect();
    }

    public function prepare(array $ids): void
    {
        $infoBlocks = InfoBlock::query()->select('title', 'description')
            ->with(['elements', 'elements.images'])->whereIn('id', $ids);

        foreach ($infoBlocks as $infoBlock) {
            $this->infoBlocks->add($infoBlock);
        }
    }

    public function findOrPrepare($id): ?InfoBlock
    {
        if ($iblock = $this->infoBlocks->where('id', $id)->first()) {
            return $iblock;
        }

        $infoBlock = InfoBlock::query()->with(['elements', 'elements.images'])->find($id);
        if ($infoBlock) {
            $this->infoBlocks->add($infoBlock);
        }
        return $infoBlock ?? null;
    }

    public function getById(int $id): ?InfoBlock
    {
        return $this->findOrPrepare($id) ?? null;
    }

    public function getElements($id)
    {
        if ($iblockElements = $this->findOrPrepare($id)?->elements) {
            return $iblockElements;
        }

        return [];
    }
}
