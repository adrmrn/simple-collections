<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Exception;

class EmptyStackException extends \Exception
{
    public static function create(): EmptyStackException
    {
        return new self('Stack is empty.');
    }
}