<?php

namespace Kontur\Dashboard\App\Traits;

trait HasShortText
{
    public function getShortText($attributeName, $width = 120, $trimMarker = '...'): ?string
    {
        if (!$this->$attributeName) return null;
        return mb_strimwidth(strip_tags($this->$attributeName), 0, $width, $trimMarker);
    }
}
