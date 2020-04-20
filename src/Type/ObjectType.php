<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Type;

use Adrmrn\SimpleCollections\Exception\UnsupportedCollectionTypeException;
use Adrmrn\SimpleCollections\Type;

final class ObjectType implements Type
{
    private $className;

    /**
     * ObjectType constructor.
     * @param string $className
     * @throws UnsupportedCollectionTypeException
     */
    public function __construct(string $className)
    {
        if (!\class_exists($className) && !\interface_exists($className)) {
            throw UnsupportedCollectionTypeException::createWithType($className);
        }

        $this->className = $className;
    }

    public function isValid($collectionItem): bool
    {
        return $collectionItem instanceof $this->className;
    }

    public function isEqual(Type $type): bool
    {
        return ($type instanceof self)
            && $this->className === $type->className;
    }

    public function __toString(): string
    {
        return $this->className;
    }
}