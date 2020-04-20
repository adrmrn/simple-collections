<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Tests\Type;

use Adrmrn\SimpleCollections\Type\ArrayType;
use Adrmrn\SimpleCollections\Type\IntegerType;
use PHPUnit\Framework\TestCase;

class ArrayTypeTest extends TestCase
{
    public function testIsValid_CollectionItemIsTypeOfArray_ReturnsTrue(): void
    {
        // arrange
        $type = new ArrayType();
        $collectionItem = ['test'];

        // act
        $isValid = $type->isValid($collectionItem);

        // assert
        $this->assertTrue($isValid);
    }

    public function testIsValid_CollectionItemHasInvalidType_ReturnsFalse(): void
    {
        // arrange
        $type = new ArrayType();
        $invalidCollectionItem = 6;

        // act
        $isValid = $type->isValid($invalidCollectionItem);

        // assert
        $this->assertFalse($isValid);
    }

    public function testToString_ParseTypeToString_ReturnsExpectedTypeName(): void
    {
        // arrange
        $type = new ArrayType();

        // act
        $typeName = (string)$type;

        // assert
        $expectedTypeName = 'array';
        $this->assertSame($expectedTypeName, $typeName);
    }

    public function testIsEqual_CompareArrayTypeToDifferentType_ReturnsFalse(): void
    {
        // arrange
        $type = new ArrayType();
        $differentType = new IntegerType();

        // act
        $isEqual = $type->isEqual($differentType);

        // assert
        $this->assertFalse($isEqual);
    }

    public function testIsEqual_CompareArrayTypeToAnotherArrayType_ReturnsTrue(): void
    {
        // arrange
        $type = new ArrayType();
        $sameType = new ArrayType();

        // act
        $isEqual = $type->isEqual($sameType);

        // assert
        $this->assertTrue($isEqual);
    }
}