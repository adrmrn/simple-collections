<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Exception;

class EmptyQueueException extends \Exception
{
    public static function create(): EmptyQueueException
    {
        return new self('Queue is empty.');
    }
}