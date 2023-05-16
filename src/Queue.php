<?php

declare(strict_types=1);

namespace Adrmrn\SimpleCollections;

use Adrmrn\SimpleCollections\Exception\EmptyQueueException;
use Adrmrn\SimpleCollections\Exception\IllegalItemTypeException;
use Adrmrn\SimpleCollections\Exception\UnsupportedCollectionTypeException;

class Queue extends AbstractCollection
{
    /**
     * @throws UnsupportedCollectionTypeException
     * @throws IllegalItemTypeException
     */
    public function __construct(string $type, array $collection = [])
    {
        parent::__construct($type);

        foreach ($collection as $collectionItem) {
            $this->enqueue($collectionItem);
        }
    }

    /**
     * @throws IllegalItemTypeException
     */
    public function enqueue(mixed $item): void
    {
        if (!$this->type->isValid($item)) {
            throw IllegalItemTypeException::createWithExpectedType($this->type);
        }

        $this->items[] = $item;
    }

    /**
     * @throws EmptyQueueException
     */
    public function peek(): mixed
    {
        if ($this->count() === 0) {
            throw EmptyQueueException::create();
        }

        return $this->items[0];
    }

    /**
     * @throws EmptyQueueException
     */
    public function dequeue(): mixed
    {
        if ($this->count() === 0) {
            throw EmptyQueueException::create();
        }

        $item = $this->items[0];
        unset($this->items[0]);
        $this->reindexItems();
        return $item;
    }

    private function reindexItems(): void
    {
        $this->items = \array_values($this->items);
    }
}
