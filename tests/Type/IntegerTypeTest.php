<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Tests\Type;

use Adrmrn\SimpleCollections\Type\FloatType;
use Adrmrn\SimpleCollections\Type\IntegerType;
use PHPUnit\Framework\TestCase;

class IntegerTypeTest extends TestCase
{
    public function testIsValid_CollectionItemIsTypeOfInteger_ReturnsTrue(): void
    {
        // arrange
        $type = new IntegerType();
        $collectionItem = 4;

        // act
        $isValid = $type->isValid($collectionItem);

        // assert
        $this->assertTrue($isValid);
    }

    public function testIsValid_CollectionItemHasInvalidType_ReturnsFalse(): void
    {
        // arrange
        $type = new IntegerType();
        $invalidCollectionItem = 'test';

        // act
        $isValid = $type->isValid($invalidCollectionItem);

        // assert
        $this->assertFalse($isValid);
    }

    public function testToString_ParseTypeToString_ReturnsExpectedTypeName(): void
    {
        // arrange
        $type = new IntegerType();

        // act
        $typeName = (string)$type;

        // assert
        $expectedTypeName = 'integer';
        $this->assertSame($expectedTypeName, $typeName);
    }

    public function testIsEqual_CompareIntegerTypeToDifferentType_ReturnsFalse(): void
    {
        // arrange
        $type = new IntegerType();
        $differentType = new FloatType();

        // act
        $isEqual = $type->isEqual($differentType);

        // assert
        $this->assertFalse($isEqual);
    }

    public function testIsEqual_CompareIntegerTypeToAnotherIntegerType_ReturnsTrue(): void
    {
        // arrange
        $type = new IntegerType();
        $sameType = new IntegerType();

        // act
        $isEqual = $type->isEqual($sameType);

        // assert
        $this->assertTrue($isEqual);
    }
}