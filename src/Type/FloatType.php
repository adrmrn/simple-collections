<?php

declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Type;

use Adrmrn\SimpleCollections\Type;

final class FloatType implements Type
{
    public function isValid($collectionItem): bool
    {
        return \is_float($collectionItem);
    }

    public function isEqual(Type $type): bool
    {
        return ($type instanceof self);
    }

    public function __toString(): string
    {
        return 'float';
    }
}
