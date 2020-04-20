<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Exception;

class UnsupportedCollectionTypeException extends \Exception
{
    public static function createWithType(string $type): UnsupportedCollectionTypeException
    {
        return new self(
            \sprintf('Unsupported collection type provided. Type: %s', $type)
        );
    }
}