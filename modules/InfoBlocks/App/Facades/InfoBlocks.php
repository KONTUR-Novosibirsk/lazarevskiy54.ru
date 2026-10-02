<?php

namespace Modules\InfoBlocks\App\Facades;

use Illuminate\Support\Facades\Facade;
use Kontur\Dashboard\App\Modules\AbstractModule;

/**
 * @method static \Modules\InfoBlocks\App\Services\InfoBlocksContainer prepare(array $ids): void
 * @method static \Modules\InfoBlocks\App\Services\InfoBlocksContainer find(int $id): InfoBlock
 *
 * @see \Modules\InfoBlocks\App\Services\InfoBlocksContainer
 *
 **/

class InfoBlocks extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'app.iblock.container';
    }
}
