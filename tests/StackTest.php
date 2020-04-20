<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Tests;

use Adrmrn\SimpleCollections\Exception\EmptyStackException;
use Adrmrn\SimpleCollections\Exception\IllegalItemTypeException;
use Adrmrn\SimpleCollections\Exception\UnsupportedCollectionTypeException;
use Adrmrn\SimpleCollections\Stack;
use Adrmrn\SimpleCollections\Tests\Fake\ExampleClass;
use Adrmrn\SimpleCollections\Type;
use Adrmrn\SimpleCollections\Type\ArrayType;
use Adrmrn\SimpleCollections\Type\BooleanType;
use Adrmrn\SimpleCollections\Type\FloatType;
use Adrmrn\SimpleCollections\Type\IntegerType;
use Adrmrn\SimpleCollections\Type\ObjectType;
use Adrmrn\SimpleCollections\Type\StringType;
use PHPUnit\Framework\TestCase;

class StackTest extends TestCase
{
    public function testCreation_CreateEmptyStackOfIntegerType_EmptyStackCreated(): void
    {
        // act
        $stack = new Stack('int');
        $isEmpty = $stack->isEmpty();
        $count = $stack->count();

        // assert
        $this->assertTrue($isEmpty);
        $expectedCount = 0;
        $this->assertSame($expectedCount, $count);
    }

    public function testCreation_CreateStackOfIntegerTypeWithInitialCollection_StackContainsAllItems(): void
    {
        // arrange
        $initialCollection = [4, 2, 66];

        // act
        $stack = new Stack('int', $initialCollection);
        $count = $stack->count();

        // assert
        $this->assertStackContainsAllItems($stack, $initialCollection);
        $expectedNumberOfItems = 3;
        $this->assertSame($expectedNumberOfItems, $count);
    }

    public function testCreation_InitialCollectionContainsItemOfInvalidType_ThrownException(): void
    {
        // arrange
        $invalidInitialCollection = [4, 6, 'test', 8];

        // assert
        $this->expectException(IllegalItemTypeException::class);

        // act
        new Stack('int', $invalidInitialCollection);
    }

    public function testCreation_CreateStackWithUnsupportedType_ThrownException(): void
    {
        // arrange
        $unsupportedType = 'test';

        // assert
        $this->expectException(UnsupportedCollectionTypeException::class);

        // act
        new Stack($unsupportedType);
    }

    public function testType_StackOfIntegerType_ReturnsExpectedTypeObject(): void
    {
        // arrange
        $stack = new Stack('int');

        // act
        $type = $stack->type();

        // assert
        $expectedType = new IntegerType();
        $this->assertEquals($expectedType, $type);
    }

    public function testPeek_StackOfIntegerTypeIsEmpty_ThrownException(): void
    {
        // arrange
        $stack = new Stack('int');

        // assert
        $this->expectException(EmptyStackException::class);

        // act
        $stack->peek();
    }

    public function testPeek_StackWithItems_ReturnsNextItemWithoutRemovingIt(): void
    {
        // arrange
        $initialCollection = [5, 67, 0, 43];
        $stack = new Stack('int', $initialCollection);
        $expectedItem = 43;

        // act
        $item = $stack->peek();
        $containsItem = $stack->contains($expectedItem);
        $count = $stack->count();

        // assert
        $this->assertSame($expectedItem, $item);
        $this->assertTrue($containsItem);
        $expectedCount = 4;
        $this->assertSame($expectedCount, $count);
    }

    public function testPop_StackIsEmpty_ThrownException(): void
    {
        // arrange
        $stack = new Stack('int');

        // assert
        $this->expectException(EmptyStackException::class);

        // act
        $stack->pop();
    }

    public function testPop_StackWithItems_ReturnsAndRemovesItem(): void
    {
        // arrange
        $initialCollection = [4, 55, 7];
        $stack = new Stack('int', $initialCollection);
        $expectedItem = 7;

        // act
        $item = $stack->pop();
        $containsItem = $stack->contains($expectedItem);
        $count = $stack->count();

        // assert
        $this->assertSame($expectedItem, $item);
        $this->assertFalse($containsItem);
        $expectedCount = 2;
        $this->assertEquals($expectedCount, $count);
    }

    public function testPop_StackHasItems_AllItemsAreReturnedInTheCorrectOrder(): void
    {
        // arrange
        $initialCollection = [66, 5, 100];
        $stack = new Stack('int', $initialCollection);

        // act
        $firstItem = $stack->pop();
        $secondItem = $stack->pop();
        $thirdItem = $stack->pop();

        // assert
        $expectedFirstItem = 100;
        $this->assertSame($expectedFirstItem, $firstItem);
        $expectedSecondItem = 5;
        $this->assertSame($expectedSecondItem, $secondItem);
        $expectedThirdItem = 66;
        $this->assertSame($expectedThirdItem, $thirdItem);
    }

    public function testContains_StackHasItem_ReturnsTrue(): void
    {
        // arrange
        $initialCollection = [5, 33, 2];
        $stack = new Stack('int', $initialCollection);
        $searchItem = 2;

        // act
        $contains = $stack->contains($searchItem);

        // assert
        $this->assertTrue($contains);
    }

    public function testContains_StackDoesNotHaveItem_ReturnsFalse(): void
    {
        // arrange
        $initialCollection = [5, 33, 2];
        $stack = new Stack('int', $initialCollection);
        $searchItem = 100;

        // act
        $contains = $stack->contains($searchItem);

        // assert
        $this->assertFalse($contains);
    }

    public function testPush_AddNewItemToStack_ItemAdded(): void
    {
        // arrange
        $stack = new Stack('int');
        $newItem = 6;

        // act
        $stack->push($newItem);
        $contains = $stack->contains($newItem);

        // assert
        $this->assertTrue($contains);
    }

    public function testPush_AddNewItemToStack_LastItemAddedToStackIsNextItemReturnedFromStack(): void
    {
        // arrange
        $stack = new Stack('int');
        $newItem = 6;

        // act
        $stack->push($newItem);
        $nextItemFromStack = $stack->peek();

        // assert
        $this->assertSame($newItem, $nextItemFromStack);
    }

    public function testPush_NewItemHasInvalidType_ThrownException(): void
    {
        // arrange
        $stack = new Stack('int');
        $invalidItem = 'test';

        // assert
        $this->expectException(IllegalItemTypeException::class);

        // act
        $stack->push($invalidItem);
    }

    public function testToArray_StackHasItems_ExpectedArrayOfItemsIsReturned(): void
    {
        // arrange
        $stack = new Stack('int', [66, 0, 10]);

        // act
        $stackAsArray = $stack->toArray();

        // assert
        $expectedStackAsArray = [66, 0, 10];
        $this->assertEquals($expectedStackAsArray, $stackAsArray);
    }

    public function testClear_StackHasItems_AllItemsAreRemoved(): void
    {
        // arrange
        $stack = new Stack('int', [4, 100, 52]);

        // act
        $stack->clear();
        $isEmpty = $stack->isEmpty();

        // assert
        $this->assertTrue($isEmpty);
    }

    public function testGetIterator_StackHasItems_ReturnedIteratorHasCopyOfStackData(): void
    {
        // arrange
        $initialCollection = [4, 50, 1];
        $stack = new Stack('int', $initialCollection);

        // act
        $iterator = $stack->getIterator();

        // assert
        $expectedIterator = new \ArrayIterator($initialCollection);
        $this->assertEquals($expectedIterator, $iterator);
    }

    public function testCount_StackHasFewItems_CountReturnedExpectedValue(): void
    {
        // arrange
        $stack = new Stack('int', [4, 5, 100]);

        // act
        $count = $stack->count();

        // assert
        $expectedCount = 3;
        $this->assertSame($expectedCount, $count);
    }

    /**
     * @dataProvider typesWithInitialCollectionsProvider
     */
    public function testCreation_CreateStackWithInitialCollection_StackContainsAllItems(
        string $type,
        array $initialCollection,
        int $expectedNumberOfItems
    ): void {
        // act
        $stack = new Stack($type, $initialCollection);
        $numberOfItems = $stack->count();

        // assert
        $this->assertStackContainsAllItems($stack, $initialCollection);
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
    public function testType_StackHasSpecificType_ReturnedExpectedTypeObject(
        string $typeAsString,
        Type $expectedObjectType
    ): void {
        // arrange
        $stack = new Stack($typeAsString);

        // act
        $typeAsString = $stack->type();

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

    private function assertStackContainsAllItems(Stack $stack, array $collectionsItems): void
    {
        $containsAllItems = true;
        foreach ($collectionsItems as $collectionItem) {
            if (!$stack->contains($collectionItem)) {
                $containsAllItems = false;
                break;
            }
        }

        $this->assertTrue($containsAllItems);
    }
}