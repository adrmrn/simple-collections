<?php

declare(strict_types=1);

namespace Adrmrn\SimpleCollections;

use Adrmrn\SimpleCollections\Exception\CollectionTypeMismatchException;
use Adrmrn\SimpleCollections\Exception\IllegalItemTypeException;
use Adrmrn\SimpleCollections\Exception\IndexOutOfBoundsException;
use Adrmrn\SimpleCollections\Exception\UnsupportedCollectionTypeException;

class ArrayList extends AbstractCollection
{
    /**
     * @throws UnsupportedCollectionTypeException
     * @throws IllegalItemTypeException
     */
    public function __construct(string $type, array $collection = [])
    {
        parent::__construct($type);

        foreach ($collection as $collectionItem) {
            $this->add($collectionItem);
        }
    }

    /**
     * @throws IllegalItemTypeException
     */
    public function add(mixed $item): void
    {
        if (!$this->type->isValid($item)) {
            throw IllegalItemTypeException::createWithExpectedType($this->type);
        }

        $this->items[] = $item;
    }

    /**
     * @throws IndexOutOfBoundsException
     */
    public function get(int $index): mixed
    {
        if ($index < 0 || $index >= $this->count()) {
            throw IndexOutOfBoundsException::createWithIndex($index);
        }

        return $this->items[$index];
    }

    public function remove(mixed $item): void
    {
        $index = \array_search($item, $this->items);
        if (false === $index) {
            return;
        }

        unset($this->items[$index]);
        $this->reindexItems();
    }

    /**
     * @throws IndexOutOfBoundsException
     */
    public function removeByIndex(int $index): void
    {
        if ($index < 0 || $index >= $this->count()) {
            throw IndexOutOfBoundsException::createWithIndex($index);
        }

        unset($this->items[$index]);
        $this->reindexItems();
    }

    public function sort(callable $callback): ArrayList
    {
        $items = $this->items;
        \uasort($items, $callback);
        return new self((string) $this->type, $items);
    }

    /**
     * @throws CollectionTypeMismatchException
     */
    public function merge(ArrayList ...$arrayLists): ArrayList
    {
        $items = [$this->items];
        foreach ($arrayLists as $arrayList) {
            if (!$this->type->isEqual($arrayList->type)) {
                throw CollectionTypeMismatchException::createWithExpectedType($this->type);
            }

            $items[] = $arrayList->items;
        }

        return new self((string) $this->type, \array_merge(...$items));
    }

    public function filter(callable $callback): ArrayList
    {
        $items = \array_filter($this->items, $callback);
        return new self((string) $this->type, $items);
    }

    private function reindexItems(): void
    {
        $this->items = \array_values($this->items);
    }
}
