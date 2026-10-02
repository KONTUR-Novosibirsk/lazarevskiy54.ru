<?php

namespace Modules\Pages\App\Services;

use DirectoryIterator;

class PageService
{

    public function getTemplates(): array
    {
        foreach (new DirectoryIterator(resource_path('views/pages')) as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            $filePath = explode('.', $fileInfo->getFilename());
            $name = array_shift($filePath);
            $pages[] = ['key' => $name, 'value' => $name];
        }
        return $pages ?? [];
    }
}
