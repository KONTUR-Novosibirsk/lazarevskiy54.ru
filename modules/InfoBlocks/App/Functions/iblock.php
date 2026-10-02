<?php
function iblock(): \Modules\InfoBlocks\App\Services\InfoBlocksContainer
{
    return \Modules\InfoBlocks\App\Facades\InfoBlocks::getFacadeRoot();
}
