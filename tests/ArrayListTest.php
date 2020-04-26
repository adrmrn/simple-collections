<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Tests;

use Adrmrn\SimpleCollections\ArrayList;
use Adrmrn\SimpleCollections\Exception\CollectionTypeMismatchException;
use Adrmrn\SimpleCollections\Exception\IllegalItemTypeException;
use Adrmrn\SimpleCollections\Exception\IndexOutOfBoundsException;
use Adrmrn\SimpleCollections\Exception\UnsupportedCollectionTypeException;
use Adrmrn\SimpleCollections\Tests\Fake\ExampleClass;
use Adrmrn\SimpleCollections\Tests\Fake\MyIntegerArrayList;
use Adrmrn\SimpleCollections\Type;
use Adrmrn\SimpleCollections\Type\ArrayType;
use Adrmrn\SimpleCollections\Type\BooleanType;
use Adrmrn\SimpleCollections\Type\FloatType;
use Adrmrn\SimpleCollections\Type\IntegerType;
use Adrmrn\SimpleCollections\Type\ObjectType;
use Adrmrn\SimpleCollections\Type\StringType;
use PHPUnit\Framework\TestCase;

class ArrayListTest extends TestCase
{
    public function testCreation_CreateInstanceOfCustomArrayListOfIntegerType_ArrayListCreated(): void
    {
        // arrange
        $initialCollection = [0, 7, -4, 56];

        // act
        $list = new MyIntegerArrayList($initialCollection);
        $count = $list->count();
        $type = $list->type();

        // assert
        $this->assertArrayListContainsAllItems($list, $initialCollection);
        $expectedCount = 4;
        $this->assertSame($expectedCount, $count);
        $expectedType = new IntegerType();
        $this->assertEquals($expectedType, $type);
    }

    public function testCreation_CreateEmptyArrayListOfIntegerType_EmptyArrayListCreated(): void
    {
        // act
        $list = new ArrayList('int');
        $isEmpty = $list->isEmpty();
        $count = $list->count();

        // assert
        $this->assertTrue($isEmpty);
        $expectedCount = 0;
        $this->assertSame($expectedCount, $count);
    }

    public function testCreation_CreateArrayListOfIntegerTypeWithInitialCollection_ArrayListContainsAllItems(): void
    {
        // arrange
        $initialCollection = [4, 2, 66];

        // act
        $list = new ArrayList('int', $initialCollection);
        $count = $list->count();

        // assert
        $this->assertArrayListContainsAllItems($list, $initialCollection);
        $expectedCount = 3;
        $this->assertSame($expectedCount, $count);
    }

    public function testCreation_InitialIntegerCollectionContainsItemOfInvalidType_ThrownException(): void
    {
        // arrange
        $invalidInitialCollection = [4, 6, 'test', 8];

        // assert
        $this->expectException(IllegalItemTypeException::class);

        // act
        new ArrayList('int', $invalidInitialCollection);
    }

    public function testCreation_CreateArrayListWithUnsupportedType_ThrownException(): void
    {
        // arrange
        $unsupportedType = 'test';

        // assert
        $this->expectException(UnsupportedCollectionTypeException::class);

        // act
        new ArrayList($unsupportedType);
    }

    public function testType_ArrayListOfIntegerType_ReturnsExpectedTypeObject(): void
    {
        // arrange
        $list = new ArrayList('int');

        // act
        $type = $list->type();

        // assert
        $expectedType = new IntegerType();
        $this->assertEquals($expectedType, $type);
    }

    public function testGet_IndexIsOutOfBounds_ThrownException(): void
    {
        // arrange
        $list = new ArrayList('int');
        $invalidIndex = 0;

        // assert
        $this->expectException(IndexOutOfBoundsException::class);

        // act
        $list->get($invalidIndex);
    }

    public function testGet_ArrayListHasItems_ExpectedItemReturned(): void
    {
        // arrange
        $initialCollection = [4, 55, 8];
        $list = new ArrayList('int', $initialCollection);

        // act
        $item = $list->get(1);

        // assert
        $expectedItem = 55;
        $this->assertSame($expectedItem, $item);
    }

    public function testRemove_ArrayListHasItems_ItemRemoved(): void
    {
        // arrange
        $initialCollection = [7, 100, 0];
        $list = new ArrayList('int', $initialCollection);
        $itemToRemove = 100;

        // act
        $list->remove($itemToRemove);
        $contains = $list->contains($itemToRemove);
        $count = $list->count();

        // assert
        $this->assertFalse($contains);
        $expectedCount = 2;
        $this->assertEquals($expectedCount, $count);
    }

    public function testRemove_ArrayListHasItem_ArrayListIsReindexingAfterCallingRemoveMethod(): void
    {
        // arrange
        $initialCollection = [7, 100, 0];
        $list = new ArrayList('int', $initialCollection);

        // act
        $firstItem = $list->get(1);
        $list->remove($firstItem);
        $secondItem = $list->get(1);

        // assert
        $expectedFirstItem = 100;
        $this->assertSame($expectedFirstItem, $firstItem);
        $expectedSecondItem = 0;
        $this->assertSame($expectedSecondItem, $secondItem);
    }

    public function testRemove_ArrayListDoesNotContainItem_NothingHasChanged(): void
    {
        // arrange
        $initialCollection = [7, 77, 0];
        $list = new ArrayList('int', $initialCollection);
        $itemToRemove = 9;

        // act
        $list->remove($itemToRemove);

        // assert
        $this->assertArrayListContainsAllItems($list, $initialCollection);
    }

    public function testRemoveByIndex_ArrayListHasItem_ItemRemoved(): void
    {
        // arrange
        $initialCollection = [7, 100, 0];
        $list = new ArrayList('int', $initialCollection);
        $itemIndexToRemove = 1;
        $itemToRemove = 100;

        // act
        $list->removeByIndex($itemIndexToRemove);
        $contains = $list->contains($itemToRemove);

        // assert
        $this->assertFalse($contains);
    }

    public function testRemoveByIndex_ArrayListHasItems_ArrayListIsReindexingAfterRemoveByIndexMethodCall(): void
    {
        // arrange
        $initialCollection = [7, 100, 0];
        $list = new ArrayList('int', $initialCollection);
        $index = 1;

        // act
        $list->removeByIndex($index);
        $itemOfIndex = $list->get($index);

        // assert
        $expectedItemOfIndex = 0;
        $this->assertSame($expectedItemOfIndex, $itemOfIndex);
    }

    public function testRemoveByIndex_ArrayListDoesNotProvidedIndex_ThrownException(): void
    {
        // arrange
        $list = new ArrayList('int');
        $indexToRemove = 0;

        // assert
        $this->expectException(IndexOutOfBoundsException::class);

        // act
        $list->removeByIndex($indexToRemove);
    }

    public function testContains_ArrayListHasItem_ReturnsTrue(): void
    {
        // arrange
        $initialCollection = [5, 33, 2];
        $list = new ArrayList('int', $initialCollection);
        $searchItem = 33;

        // act
        $contains = $list->contains($searchItem);

        // assert
        $this->assertTrue($contains);
    }

    public function testContains_ArrayListDoesNotHaveItem_ReturnsFalse(): void
    {
        // arrange
        $initialCollection = [5, 33, 2];
        $list = new ArrayList('int', $initialCollection);
        $searchItem = 100;

        // act
        $contains = $list->contains($searchItem);

        // assert
        $this->assertFalse($contains);
    }

    public function testAdd_AddNewItemToArrayList_ItemAdded(): void
    {
        // arrange
        $list = new ArrayList('int');
        $newItem = 6;

        // act
        $list->add($newItem);
        $contains = $list->contains($newItem);

        // assert
        $this->assertTrue($contains);
    }

    public function testAdd_NewItemHasInvalidType_ThrownException(): void
    {
        // arrange
        $list = new ArrayList('int');
        $invalidItem = 'test';

        // assert
        $this->expectException(IllegalItemTypeException::class);

        // act
        $list->add($invalidItem);
    }

    public function testSort_ProvideSortCallback_ReturnedArrayListHasItemsInExpectedOrder(): void
    {
        // arrange
        $initialCollection = [5, 66, 0, -3, 7];
        $list = new ArrayList('int', $initialCollection);
        $sortCallback = function (int $itemA, int $itemB) {
            return $itemA <=> $itemB;
        };

        // act
        $sortedList = $list->sort($sortCallback);

        // assert
        $expectedSortedList = new ArrayList('int', [-3, 0, 5, 7, 66]);
        $this->assertEquals($expectedSortedList, $sortedList);
    }

    public function testSort_ProvideSortCallback_OriginalArrayListHasNotChanged(): void
    {
        // arrange
        $initialCollection = [5, 66, 0, -3, 7];
        $list = new ArrayList('int', $initialCollection);
        $sortCallback = function (int $itemA, int $itemB) {
            return $itemA <=> $itemB;
        };

        // act
        $list->sort($sortCallback);

        // assert
        $expectedOriginalList = new ArrayList('int', $initialCollection);
        $this->assertEquals($expectedOriginalList, $list);
    }

    public function testMerge_HaveFewArrayLists_ArrayListsAreMerged(): void
    {
        // arrange
        $firstList = new ArrayList('int', [5, 0, 3]);
        $secondList = new ArrayList('int', [100, -6, 1]);
        $thirdList = new ArrayList('int', [4]);

        // act
        $mergedList = $firstList->merge($secondList, $thirdList);

        // assert
        $expectedMergedList = new ArrayList('int', [5, 0, 3, 100, -6, 1, 4]);
        $this->assertEquals($expectedMergedList, $mergedList);
    }

    public function testMerge_HaveArrayListsOfDifferentType_ThrownException(): void
    {
        // arrange
        $firstList = new ArrayList('int', [5, 0, 3]);
        $secondList = new ArrayList('string', ['a', 'b', 'c']);

        // assert
        $this->expectException(CollectionTypeMismatchException::class);

        // act
        $firstList->merge($secondList);
    }

    public function testFilter_ProvideFilterCallback_ReturnedArrayListHasExpectedItems(): void
    {
        // arrange
        $initialCollection = [5, 66, 0, -3, 7, -50];
        $list = new ArrayList('int', $initialCollection);
        $filterCallback = function (int $item) {
            return $item >= 0;
        };

        // act
        $filteredList = $list->filter($filterCallback);

        // assert
        $expectedFilteredList = new ArrayList('int', [5, 66, 0, 7]);
        $this->assertEquals($expectedFilteredList, $filteredList);
    }

    public function testFilter_ProvideFilterCallback_OriginalArrayListHasNotChanged(): void
    {
        // arrange
        $initialCollection = [5, 66, 0, -3, 7];
        $list = new ArrayList('int', $initialCollection);
        $filterCallback = function (int $item) {
            return $item >= 0;
        };

        // act
        $list->filter($filterCallback);

        // assert
        $expectedOriginalList = new ArrayList('int', $initialCollection);
        $this->assertEquals($expectedOriginalList, $list);
    }

    public function testToArray_ArrayListHasItems_ExpectedArrayOfItemsIsReturned(): void
    {
        // arrange
        $list = new ArrayList('int', [66, 0, 10]);

        // act
        $listAsArray = $list->toArray();

        // assert
        $expectedListAsArray = [66, 0, 10];
        $this->assertEquals($expectedListAsArray, $listAsArray);
    }

    public function testClear_ArrayListHasItems_AllItemsAreRemoved(): void
    {
        // arrange
        $list = new ArrayList('int', [4, 100, 52]);

        // act
        $list->clear();
        $isEmpty = $list->isEmpty();

        // assert
        $this->assertTrue($isEmpty);
    }

    public function testGetIterator_ArrayListHasItems_ReturnedIteratorHasCopyOfArrayListData(): void
    {
        // arrange
        $initialCollection = [4, 50, 1];
        $list = new ArrayList('int', $initialCollection);

        // act
        $iterator = $list->getIterator();

        // assert
        $expectedIterator = new \ArrayIterator($initialCollection);
        $this->assertEquals($expectedIterator, $iterator);
    }

    public function testCount_ArrayListHasFewItems_CountReturnedExpectedValue(): void
    {
        // arrange
        $list = new ArrayList('int', [4, 5, 100]);

        // act
        $count = $list->count();

        // assert
        $expectedCount = 3;
        $this->assertSame($expectedCount, $count);
    }

    /**
     * @dataProvider typesWithInitialCollectionsProvider
     */
    public function testCreation_CreateArrayListWithInitialCollection_ArrayListContainsAllItems(
        string $type,
        array $initialCollection,
        int $expectedNumberOfItems
    ): void {
        // act
        $list = new ArrayList($type, $initialCollection);
        $numberOfItems = $list->count();

        // assert
        $this->assertArrayListContainsAllItems($list, $initialCollection);
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
    public function testType_ArrayListHasSpecificType_ReturnedExpectedTypeObject(
        string $typeAsString,
        Type $expectedObjectType
    ): void {
        // arrange
        $list = new ArrayList($typeAsString);

        // act
        $typeAsString = $list->type();

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

    private function assertArrayListContainsAllItems(ArrayList $list, array $collectionsItems): void
    {
        $containsAllItems = true;
        foreach ($collectionsItems as $collectionItem) {
            if (!$list->contains($collectionItem)) {
                $containsAllItems = false;
                break;
            }
        }

        $this->assertTrue($containsAllItems);
    }
}