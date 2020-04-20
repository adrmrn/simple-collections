<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Exception;

use Adrmrn\SimpleCollections\Type;

class IllegalItemTypeException extends \Exception
{
    public static function createWithExpectedType(Type $expectedType): IllegalItemTypeException
    {
        return new self(
            \sprintf('Item with invalid type provided. Collection type: %s', (string)$expectedType)
        );
    }
}