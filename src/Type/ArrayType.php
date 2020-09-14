<?php

declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Type;

use Adrmrn\SimpleCollections\Type;

final class ArrayType implements Type
{
    public function isValid($collectionItem): bool
    {
        return \is_array($collectionItem);
    }

    public function isEqual(Type $type): bool
    {
        return ($type instanceof self);
    }

    public function __toString(): string
    {
        return 'array';
    }
}
