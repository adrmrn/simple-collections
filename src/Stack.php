<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections;

use Adrmrn\SimpleCollections\Exception\EmptyStackException;
use Adrmrn\SimpleCollections\Exception\IllegalItemTypeException;
use Adrmrn\SimpleCollections\Exception\UnsupportedCollectionTypeException;

class Stack extends AbstractCollection
{
    /**
     * Stack constructor.
     * @param string $type
     * @param array $collection
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
     * @param mixed $item
     * @throws IllegalItemTypeException
     */
    public function push($item): void
    {
        if (!$this->type->isValid($item)) {
            throw IllegalItemTypeException::createWithExpectedType($this->type);
        }

        $this->items[] = $item;
    }

    /**
     * @return mixed
     * @throws EmptyStackException
     */
    public function peek()
    {
        if ($this->count() === 0) {
            throw EmptyStackException::create();
        }

        return \end($this->items);
    }

    /**
     * @return mixed
     * @throws EmptyStackException
     */
    public function pop()
    {
        if ($this->count() === 0) {
            throw EmptyStackException::create();
        }

        return \array_pop($this->items);
    }
}