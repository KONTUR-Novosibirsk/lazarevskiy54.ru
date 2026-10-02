<?php

namespace Modules\Shop\App\Exceptions;

use Exception;

class UniqueAliasException extends Exception
{
    public function render()
    {
        return response()->json(["error" => true, "alias" => $this->getMessage()]);
    }
}
