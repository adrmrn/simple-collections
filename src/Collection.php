<?php

declare(strict_types=1);

namespace Adrmrn\SimpleCollections;

interface Collection extends \Countable, \IteratorAggregate
{
    /**
     * @param mixed $searchItem
     * @param bool $strict
     * @return bool
     */
    public function contains($searchItem, bool $strict = false): bool;

    public function isEmpty(): bool;

    public function type(): Type;

    public function toArray(): array;

    public function clear(): void;
}
