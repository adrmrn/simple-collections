[![Build Status](https://travis-ci.com/adrmrn/simple-collections.svg?branch=master)](https://travis-ci.com/adrmrn/simple-collections)

# Simple Collections
As you probably know, PHP language doesn’t support generic collections. Simple Collections library tries dealing with it and providing set of collection classes typed through constructor. There are few collections inspired by languages like Java or C#: `Queue`, `Stack` and `ArrayList`.

## Collections
Each specific collection implements `Collection` interface with basic operations: `contains($item)`, `count()`, `isEmpty()`, `toArray()`, `clear()`. 

First argument passing to constructor is required and must be a collection `Type`. Second argument sets initial values of collection and is optional. 

Type handles collection type and takes care of the correctness of data. Type can be provided to collection constructor in three ways:
1. Provide scalar type as string: `array`, `bool`, `float`, `int`, `string`, ex.
```php
$list = new ArrayList('int');
```
2. Provide scalar type using `Type` interface with defined constants in it, `Type::ARRAY`, `Type::BOOLEAN`, `Type::FLOAT`, `Type::INTEGER`, `Type::STRING`, ex.
```php
$list = new ArrayList(Type::INTEGER);
```
3. Provide class or interface, ex.
```php
$list = new ArrayList(\DateTimeInteface::class);
```

## Example of usage

### Queue
It's classic FIFO (First In First Out) collection. Queue provides three methods specific for this collection: `enqueue($item)`, `dequeue()` & `peek()`.
```php
$queue = new Queue('int');

$queue->enqueue(6);
$queue->enqueue(-10);

$queue->peek(); // 6
$queue->dequeue(); // 6

$queue->peek(); // -10
$queue->dequeue(); // -10
```

### Stack
It's classic LIFO (Last In First Out) collection. Stack provides three methods specific for this collection: `push($item)`, `pop()` & `peek()`.
```php
$stack = new Stack('int');

$stack->push(6);
$stack->push(-10);

$stack->peek(); // -10
$stack->pop(); // -10

$stack->peek(); // 6
$stack->pop(); // 6
```

### ArrayList
It's a collection based on array and provides few methods for effective managing collection: `add($item)`, `get($index)`, `remove($item)`, `removeByIndex($index)`, `sort($callback)`, `filter($callback)` & `merge($list)`.
```php
$list = new ArrayList('int', ['a', 'b', 'c', 'd']);

$list->add('e');

$list->get(1); // b
$list->get(2); // c

$list->remove('c'); // remove 'c' item
$list->removeByIndex(2); // remove 'd' item (because collection is reindexing after remove operation)
```

## Exceptions
General exceptions relevant to each collection.

### UnsupportedCollectionTypeException
Exception is thrown when the client creates collection with type that is unsupported.
```php
$list = new ArrayList('invalidType'); // throw UnsupportedCollectionTypeException
```

### IllegalItemTypeException
Exception is thrown when the client adds item that type is different than collection type.
```php
$list = new ArrayList('int');
$list->add('test'); // throw IllegalItemTypeException
```

Depending on implementation, collections can throw specific exceptions.

### CollectionTypeMismatchException
Exception is thrown when collections with different types are interacting with each other.
```php
$firstList = new ArrayList('int');
$secondList = new ArrayList('string');

$firstList->merge($secondList); // throw CollectionTypeMismatchException
```

### IndexOutOfBoundsException
Exception is thrown when the client provides index that is out of range and doesn’t exist in collection.
```php
$list = new ArrayList('int');
$list->remove(0); // throw IndexOutOfBoundsException
```

### EmptyQueueException
Exception is thrown when the client tries getting items from Queue, but collection is empty.
```php
$queue = new Queue('int');
$queue->dequeue(); // throw EmptyQueueException
```

### EmptyStackException
Exception is thrown when the client tries getting items from Stack, but collection is empty.
```php
$stack = new Stack('int');
$stack->pop(); // throw EmptyStackException
```

## Custom collection
You can extend each collection and create custom collection class with fixed type. Thanks to it, the type during creation can be omitted.
```php
class MyIntegerArrayList extends ArrayList
{
    public function __construct(array $collection = [])
    {
        parent::__construct('int', $collection);
    }
}

$list = new MyIntegerArrayList();
```

## Unit tests
In `tests` directory you can find unit tests for all collections. To run tests just execute this command:
```bash
php vendor/bin/phpunit run
```

## Feedback
Any feedback is welcomed. Just let me know if you have any ideas or questions.