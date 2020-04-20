<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Type;

use Adrmrn\SimpleCollections\Exception\UnsupportedCollectionTypeException;
use Adrmrn\SimpleCollections\Type;

class TypeFactory
{
    /**
     * @param string $typeAsString
     * @return Type
     * @throws UnsupportedCollectionTypeException
     */
    public static function createFromString(string $typeAsString): Type
    {
        if (\class_exists($typeAsString) || \interface_exists($typeAsString)) {
            return new ObjectType($typeAsString);
        }

        switch ($typeAsString) {
            case 'array':
                $type = new ArrayType();
                break;

            case 'bool':
            case 'boolean':
                $type = new BooleanType();
                break;

            case 'float':
            case 'double':
                $type = new FloatType();
                break;

            case 'int':
            case 'integer':
                $type = new IntegerType();
                break;

            case 'string':
                $type = new StringType();
                break;

            default:
                throw UnsupportedCollectionTypeException::createWithType($typeAsString);
        }

        return $type;
    }
}