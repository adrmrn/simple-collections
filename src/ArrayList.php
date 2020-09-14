<?php

declare(strict_types=1);

namespace Adrmrn\SimpleCollections;

use Adrmrn\SimpleCollections\Exception\CollectionTypeMismatchException;
use Adrmrn\SimpleCollections\Exception\IllegalItemTypeException;
use Adrmrn\SimpleCollections\Exception\IndexOutOfBoundsException;

class ArrayList extends AbstractCollection
{
    /**
     * ArrayList constructor.
     * @param string $type
     * @param array $collection
     * @throws Exception\UnsupportedCollectionTypeException
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
     * @param mixed $item
     * @throws IllegalItemTypeException
     */
    public function add($item): void
    {
        if (!$this->type->isValid($item)) {
            throw IllegalItemTypeException::createWithExpectedType($this->type);
        }

        $this->items[] = $item;
    }

    /**
     * @param int $index
     * @throws IndexOutOfBoundsException
     * @return mixed
     */
    public function get(int $index)
    {
        if ($index < 0 || $index >= $this->count()) {
            throw IndexOutOfBoundsException::createWithIndex($index);
        }

        return $this->items[$index];
    }

    /**
     * @param mixed $item
     */
    public function remove($item): void
    {
        $index = \array_search($item, $this->items);
        if (false === $index) {
            return;
        }

        unset($this->items[$index]);
        $this->reindexItems();
    }

    /**
     * @param int $index
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
        return new self((string)$this->type, $items);
    }

    /**
     * @param ArrayList ...$arrayLists
     * @return ArrayList
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

        return new self((string)$this->type, \array_merge(...$items));
    }

    public function filter(callable $callback): ArrayList
    {
        $items = \array_filter($this->items, $callback);
        return new self((string)$this->type, $items);
    }

    private function reindexItems(): void
    {
        $this->items = \array_values($this->items);
    }
}
