<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections;

use Adrmrn\SimpleCollections\Exception\UnsupportedCollectionTypeException;
use Adrmrn\SimpleCollections\Type\TypeFactory;

abstract class AbstractCollection implements \Countable, \IteratorAggregate
{
    /**
     * @var Type
     */
    protected $type;
    /**
     * @var array
     */
    protected $items = [];

    /**
     * AbstractCollection constructor.
     * @param string $type
     * @throws UnsupportedCollectionTypeException
     */
    protected function __construct(string $type)
    {
        $this->type = TypeFactory::createFromString($type);
    }

    /**
     * @param mixed $searchItem
     * @param bool $strict
     * @return bool
     */
    public function contains($searchItem, bool $strict = false): bool
    {
        return \in_array($searchItem, $this->items, $strict);
    }

    public function count(): int
    {
        return \count($this->items);
    }

    public function isEmpty(): bool
    {
        return \count($this->items) === 0;
    }

    public function type(): Type
    {
        return $this->type;
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->items);
    }
}