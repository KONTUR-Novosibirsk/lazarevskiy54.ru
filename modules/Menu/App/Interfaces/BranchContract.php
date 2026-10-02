<?php

namespace Modules\Menu\App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface BranchContract
{
    public function toTree();

    public function setMaxLevel(int $level): static;
}
