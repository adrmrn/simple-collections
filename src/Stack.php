<?php

declare(strict_types=1);

namespace Adrmrn\SimpleCollections;

use Adrmrn\SimpleCollections\Exception\EmptyStackException;
use Adrmrn\SimpleCollections\Exception\IllegalItemTypeException;
use Adrmrn\SimpleCollections\Exception\UnsupportedCollectionTypeException;

class Stack extends AbstractCollection
{
    /**
     * @throws UnsupportedCollectionTypeException
     * @throws IllegalItemTypeException
     */
    public function __construct(string $type, array $collection = [])
    {
        parent::__construct($type);

        foreach ($collection as $collectionItem) {
            $this->push($collectionItem);
        }
    }

    /**
     * @throws IllegalItemTypeException
     */
    public function push(mixed $item): void
    {
        if (!$this->type->isValid($item)) {
            throw IllegalItemTypeException::createWithExpectedType($this->type);
        }

        $this->items[] = $item;
    }

    /**
     * @throws EmptyStackException
     */
    public function peek(): mixed
    {
        if ($this->count() === 0) {
            throw EmptyStackException::create();
        }

        return \end($this->items);
    }

    /**
     * @throws EmptyStackException
     */
    public function pop(): mixed
    {
        if ($this->count() === 0) {
            throw EmptyStackException::create();
        }

        return \array_pop($this->items);
    }
}
