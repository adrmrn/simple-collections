<?php

declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Type;

use Adrmrn\SimpleCollections\Exception\UnsupportedCollectionTypeException;
use Adrmrn\SimpleCollections\Type;

class TypeFactory
{
    /**
     * @throws UnsupportedCollectionTypeException
     */
    public static function createFromString(string $typeAsString): Type
    {
        if (\class_exists($typeAsString) || \interface_exists($typeAsString)) {
            return new ObjectType($typeAsString);
        }

        return match ($typeAsString) {
            'array' => new ArrayType(),
            'bool', 'boolean' => new BooleanType(),
            'float', 'double' => new FloatType(),
            'int', 'integer' => new IntegerType(),
            'string' => new StringType(),
            default => throw UnsupportedCollectionTypeException::createWithType($typeAsString),
        };
    }
}
