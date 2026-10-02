<?php

namespace Kontur\Dashboard\App\DTO;

final readonly class Filter
{
    private function __construct(
        public int $perPage,
        public ?bool $isActive,
        public ?string $searchTerm,
        public string $sortColumn,
        public string $sortOrder,
    ) {}

    public static function default(): self
    {
        return new self(
            perPage:    settings('per_page', default: 10),
            isActive:   true,
            searchTerm: null,
            sortColumn: 'id',
            sortOrder:  'desc',
        );
    }

    public static function make(array $params = []): self
    {
        $default = self::default();

        return new self(
            perPage:    array_key_exists('perPage', $params)    ? $params['perPage']    : $default->perPage,
            isActive:   array_key_exists('isActive', $params)   ? $params['isActive']   : $default->isActive,
            searchTerm: array_key_exists('searchTerm', $params) ? $params['searchTerm'] : $default->searchTerm,
            sortColumn: array_key_exists('sortColumn', $params) ? $params['sortColumn'] : $default->sortColumn,
            sortOrder:  array_key_exists('sortOrder', $params)  ? $params['sortOrder']  : $default->sortOrder,
        );
    }
}
