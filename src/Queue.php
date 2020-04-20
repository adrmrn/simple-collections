<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections;

use Adrmrn\SimpleCollections\Exception\EmptyQueueException;
use Adrmrn\SimpleCollections\Exception\IllegalItemTypeException;

class Queue extends AbstractCollection
{
    /**
     * Queue constructor.
     * @param string $type
     * @param array $collection
     * @throws Exception\UnsupportedCollectionTypeException
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
     * @param mixed $item
     * @throws IllegalItemTypeException
     */
    public function enqueue($item): void
    {
        if (!$this->type->isValid($item)) {
            throw IllegalItemTypeException::createWithExpectedType($this->type);
        }

        $this->items[] = $item;
    }

    /**
     * @return mixed
     * @throws EmptyQueueException
     */
    public function peek()
    {
        if ($this->count() === 0) {
            throw EmptyQueueException::create();
        }

        return $this->items[0];
    }

    /**
     * @return mixed
     * @throws EmptyQueueException
     */
    public function dequeue()
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