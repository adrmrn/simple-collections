<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Tests;

use Adrmrn\SimpleCollections\Exception\EmptyQueueException;
use Adrmrn\SimpleCollections\Exception\IllegalItemTypeException;
use Adrmrn\SimpleCollections\Exception\UnsupportedCollectionTypeException;
use Adrmrn\SimpleCollections\Queue;
use Adrmrn\SimpleCollections\Tests\Fake\ExampleClass;
use Adrmrn\SimpleCollections\Type;
use Adrmrn\SimpleCollections\Type\ArrayType;
use Adrmrn\SimpleCollections\Type\BooleanType;
use Adrmrn\SimpleCollections\Type\FloatType;
use Adrmrn\SimpleCollections\Type\IntegerType;
use Adrmrn\SimpleCollections\Type\ObjectType;
use Adrmrn\SimpleCollections\Type\StringType;
use PHPUnit\Framework\TestCase;

class QueueTest extends TestCase
{
    public function testCreation_CreateEmptyQueueOfIntegerType_EmptyQueueCreated(): void
    {
        // act
        $queue = new Queue('int');
        $isEmpty = $queue->isEmpty();
        $count = $queue->count();

        // assert
        $this->assertTrue($isEmpty);
        $expectedCount = 0;
        $this->assertSame($expectedCount, $count);
    }

    public function testCreation_CreateQueueOfIntegerTypeWithInitialCollection_QueueContainsAllItems(): void
    {
        // arrange
        $initialCollection = [4, 2, 66];

        // act
        $queue = new Queue('int', $initialCollection);
        $count = $queue->count();

        // assert
        $this->assertQueueContainsAllItems($queue, $initialCollection);
        $expectedNumberOfItems = 3;
        $this->assertSame($expectedNumberOfItems, $count);
    }

    public function testCreation_InitialIntegerCollectionContainsItemOfInvalidType_ThrownException(): void
    {
        // arrange
        $invalidInitialCollection = [4, 6, 'test', 8];

        // assert
        $this->expectException(IllegalItemTypeException::class);

        // act
        new Queue('int', $invalidInitialCollection);
    }

    public function testCreation_CreateQueueWithUnsupportedType_ThrownException(): void
    {
        // arrange
        $unsupportedType = 'test';

        // assert
        $this->expectException(UnsupportedCollectionTypeException::class);

        // act
        new Queue($unsupportedType);
    }

    public function testType_QueueOfIntegerType_ReturnsExpectedTypeObject(): void
    {
        // arrange
        $queue = new Queue('int');

        // act
        $type = $queue->type();

        // assert
        $expectedType = new IntegerType();
        $this->assertEquals($expectedType, $type);
    }

    public function testPeek_QueueOfIntegerTypeIsEmpty_ThrownException(): void
    {
        // arrange
        $queue = new Queue('int');

        // assert
        $this->expectException(EmptyQueueException::class);

        // act
        $queue->peek();
    }

    public function testPeek_QueueWithItems_ReturnsNextItemWithoutRemovingIt(): void
    {
        // arrange
        $initialCollection = [5, 67, 0, 43];
        $queue = new Queue('int', $initialCollection);
        $expectedItem = 5;

        // act
        $item = $queue->peek();
        $containsItem = $queue->contains($expectedItem);
        $count = $queue->count();

        // assert
        $this->assertSame($expectedItem, $item);
        $this->assertTrue($containsItem);
        $expectedCount = 4;
        $this->assertSame($expectedCount, $count);
    }

    public function testDequeue_QueueIsEmpty_ThrownException(): void
    {
        // arrange
        $queue = new Queue('int');

        // assert
        $this->expectException(EmptyQueueException::class);

        // act
        $queue->dequeue();
    }

    public function testDequeue_QueueWithItems_ReturnsAndRemovesItem(): void
    {
        // arrange
        $initialCollection = [4, 55, 7];
        $queue = new Queue('int', $initialCollection);
        $expectedItem = 4;

        // act
        $item = $queue->dequeue();
        $containsItem = $queue->contains($expectedItem);
        $count = $queue->count();

        // assert
        $this->assertSame($expectedItem, $item);
        $this->assertFalse($containsItem);
        $expectedCount = 2;
        $this->assertEquals($expectedCount, $count);
    }

    public function testDequeue_QueueHasItems_AllItemsAreReturnedInTheCorrectOrder(): void
    {
        // arrange
        $initialCollection = [66, 5, 100];
        $queue = new Queue('int', $initialCollection);

        // act
        $firstItem = $queue->dequeue();
        $secondItem = $queue->dequeue();
        $thirdItem = $queue->dequeue();

        // assert
        $expectedFirstItem = 66;
        $this->assertSame($expectedFirstItem, $firstItem);
        $expectedSecondItem = 5;
        $this->assertSame($expectedSecondItem, $secondItem);
        $expectedThirdItem = 100;
        $this->assertSame($expectedThirdItem, $thirdItem);
    }

    public function testContains_QueueHasItem_ReturnsTrue(): void
    {
        // arrange
        $initialCollection = [5, 33, 2];
        $queue = new Queue('int', $initialCollection);
        $searchItem = 2;

        // act
        $contains = $queue->contains($searchItem);

        // assert
        $this->assertTrue($contains);
    }

    public function testContains_QueueDoesNotHaveItem_ReturnsFalse(): void
    {
        // arrange
        $initialCollection = [5, 33, 2];
        $queue = new Queue('int', $initialCollection);
        $searchItem = 100;

        // act
        $contains = $queue->contains($searchItem);

        // assert
        $this->assertFalse($contains);
    }

    public function testEnqueue_AddNewItemToQueue_ItemAdded(): void
    {
        // arrange
        $queue = new Queue('int');
        $newItem = 6;

        // act
        $queue->enqueue($newItem);
        $contains = $queue->contains($newItem);

        // assert
        $this->assertTrue($contains);
    }

    public function testEnqueue_NewItemHasInvalidType_ThrownException(): void
    {
        // arrange
        $queue = new Queue('int');
        $invalidItem = 'test';

        // assert
        $this->expectException(IllegalItemTypeException::class);

        // act
        $queue->enqueue($invalidItem);
    }

    public function testToArray_QueueHasItems_ExpectedArrayOfItemsIsReturned(): void
    {
        // arrange
        $queue = new Queue('int', [66, 0, 10]);

        // act
        $queueAsArray = $queue->toArray();

        // assert
        $expectedQueueAsArray = [66, 0, 10];
        $this->assertEquals($expectedQueueAsArray, $queueAsArray);
    }

    public function testClear_QueueHasItems_AllItemsAreRemoved(): void
    {
        // arrange
        $queue = new Queue('int', [4, 100, 52]);

        // act
        $queue->clear();
        $isEmpty = $queue->isEmpty();

        // assert
        $this->assertTrue($isEmpty);
    }

    public function testGetIterator_QueueHasItems_ReturnedIteratorHasCopyOfQueueData(): void
    {
        // arrange
        $initialCollection = [4, 50, 1];
        $queue = new Queue('int', $initialCollection);

        // act
        $iterator = $queue->getIterator();

        // assert
        $expectedIterator = new \ArrayIterator($initialCollection);
        $this->assertEquals($expectedIterator, $iterator);
    }

    public function testCount_QueueHasFewItems_CountReturnedExpectedValue(): void
    {
        // arrange
        $queue = new Queue('int', [4, 5, 100]);

        // act
        $count = $queue->count();

        // assert
        $expectedCount = 3;
        $this->assertSame($expectedCount, $count);
    }

    /**
     * @dataProvider typesWithInitialCollectionsProvider
     */
    public function testCreation_CreateQueueWithInitialCollection_QueueContainsAllItems(
        string $type,
        array $initialCollection,
        int $expectedNumberOfItems
    ): void {
        // act
        $queue = new Queue($type, $initialCollection);
        $numberOfItems = $queue->count();

        // assert
        $this->assertQueueContainsAllItems($queue, $initialCollection);
        $this->assertSame($expectedNumberOfItems, $numberOfItems);
    }

    public function typesWithInitialCollectionsProvider(): array
    {
        // [type, initial collection, expected number of items]
        return [
            'collectionOfArrayType' => [Type::ARRAY, [['a'], ['b']], 2],
            'collectionOfBooleanType' => [Type::BOOLEAN, [true, true, false, true], 4],
            'collectionOfFloatType' => [Type::FLOAT, [2.2, 43.1, 45.9], 3],
            'collectionOfIntegerType' => [Type::INTEGER, [4, 66, 7], 3],
            'collectionOfStringType' => [Type::STRING, ['a', 'b', 'c', 'd', 'e'], 5],
            'collectionOfObjectType' => [ExampleClass::class, [new ExampleClass()], 1]
        ];
    }

    /**
     * @dataProvider typesAsStringWithTypesObjectsProvider
     */
    public function testType_QueueHasSpecificType_ReturnedExpectedTypeObject(
        string $typeAsString,
        Type $expectedObjectType
    ): void {
        // arrange
        $queue = new Queue($typeAsString);

        // act
        $typeAsString = $queue->type();

        // assert
        $this->assertEquals($expectedObjectType, $typeAsString);
    }

    public function typesAsStringWithTypesObjectsProvider(): array
    {
        // [type as string, expected type object]
        return [
            'arrayType' => [Type::ARRAY, new ArrayType()],
            'booleanType' => [Type::BOOLEAN, new BooleanType()],
            'floatType' => [Type::FLOAT, new FloatType()],
            'integerType' => [Type::INTEGER, new IntegerType()],
            'stringType' => [Type::STRING, new StringType()],
            'objectType' => [ExampleClass::class, new ObjectType(ExampleClass::class)]
        ];
    }

    private function assertQueueContainsAllItems(Queue $queue, array $collectionsItems): void
    {
        $containsAllItems = true;
        foreach ($collectionsItems as $collectionItem) {
            if (!$queue->contains($collectionItem)) {
                $containsAllItems = false;
                break;
            }
        }

        $this->assertTrue($containsAllItems);
    }
}