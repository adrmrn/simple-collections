<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Exception;

use Adrmrn\SimpleCollections\Type;

class CollectionTypeMismatchException extends \Exception
{
    public static function createWithExpectedType(Type $expectedType): CollectionTypeMismatchException
    {
        return new self(
            \sprintf('Provided collection\'s type is different than expected. Expected: %s', (string)$expectedType)
        );
    }
}