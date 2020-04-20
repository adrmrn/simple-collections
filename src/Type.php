<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections;

interface Type
{
    public const ARRAY = 'array';
    public const BOOLEAN = 'bool';
    public const FLOAT = 'float';
    public const INTEGER = 'int';
    public const STRING = 'string';

    public function isValid($collectionItem): bool;
    public function isEqual(Type $type): bool;
    public function __toString(): string;
}