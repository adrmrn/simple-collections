<?php

declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Type;

use Adrmrn\SimpleCollections\Type;

final class IntegerType implements Type
{
    public function isValid($collectionItem): bool
    {
        return is_int($collectionItem);
    }

    public function isEqual(Type $type): bool
    {
        return ($type instanceof self);
    }

    public function __toString(): string
    {
        return 'integer';
    }
}
