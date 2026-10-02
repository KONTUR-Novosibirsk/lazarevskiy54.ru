<?php

namespace Modules\Shop\App\Traits;

/**
 * @var \Illuminate\Database\Eloquent\Model $this
 *
 */
trait AliasHelperTrait
{
    protected string $startWord = '';

    protected string $stopWord = '';

    public array $parts = [];

    public static function bootAliasHelperTrait()
    {

    }

    /**
     * @param string $uri request uri
     *
     * @return array parts of slug
     */
    public function parseUri(string $uri): array
    {
        if (!empty($this->parts)) {
            return $this->parts;
        }

        if ($this->getStartWord() && $this->getStopWord()) {
            $this->parseBetweenWords($uri);
        } else {
            $this->parseFull($uri);
        }

        return $this->parts;
    }

    public function getByAliasFromUri(string $uri)
    {
        $parts = $this->parseUri($uri);

        $alias = array_pop($parts);

        return $this::query()->where('alias', $alias)->first();
    }

    /**
     * @param string $uri request uri
     */
    public function checkPathValid(string $uri): bool
    {
        $path = $this->parseUri($uri);

        $parts = $this::query()->whereIn('alias', $path)->get();

        if (count($parts) !== count($path)) {
            return false;
        }

        foreach ($parts as $key => $part) {
            if (!isset($parts[$key + 1])) break;

            if (!$part->children()
                ->where('id', $parts[$key + 1]->id)
                ->first()) {
                return false;
            }
        }

        return true;
    }

    protected function parseFull($uri)
    {
        foreach (explode('/', $uri) as $part) {
            $this->parts[] = $part;
        }
    }

    protected function parseBetweenWords($uri)
    {
        $start = false;

        foreach (explode('/', $uri) as $part) {
            if ($part === $this->getStartWord()) {
                $start = true;
                continue;
            }
            if (!$start || empty($part)) continue;
            if ($part === $this->getStopWord()) break;

            $this->parts[] = $part;
        }
    }

    public function getStartWord()
    {
        return $this->startWord;
    }

    public function getStopWord()
    {
        return $this->stopWord;
    }
}
