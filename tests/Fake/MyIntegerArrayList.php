<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Tests\Fake;

use Adrmrn\SimpleCollections\ArrayList;

class MyIntegerArrayList extends ArrayList
{
    public function __construct(array $collection = [])
    {
        parent::__construct('int', $collection);
    }
}