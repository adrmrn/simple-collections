<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Exception;

class IndexOutOfBoundsException extends \Exception
{
    public static function createWithIndex(int $index): IndexOutOfBoundsException
    {
        return new self(
            \sprintf('Index out of bounds. Index: %d', $index)
        );
    }
}