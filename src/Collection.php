<?php

declare(strict_types=1);

namespace Adrmrn\SimpleCollections;

interface Collection extends \Countable, \IteratorAggregate
{
    public function contains(mixed $searchItem, bool $strict = false): bool;

    public function isEmpty(): bool;

    public function type(): Type;

    public function toArray(): array;

    public function clear(): void;
}
