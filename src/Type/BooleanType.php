<?php

declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Type;

use Adrmrn\SimpleCollections\Type;

final class BooleanType implements Type
{
    public function isValid(mixed $collectionItem): bool
    {
        return \is_bool($collectionItem);
    }

    public function isEqual(Type $type): bool
    {
        return ($type instanceof self);
    }

    public function __toString(): string
    {
        return 'boolean';
    }
}
