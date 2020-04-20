<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Tests\Type;

use Adrmrn\SimpleCollections\Type\FloatType;
use Adrmrn\SimpleCollections\Type\IntegerType;
use PHPUnit\Framework\TestCase;

class FloatTypeTest extends TestCase
{
    public function testIsValid_CollectionItemIsTypeOfFloat_ReturnsTrue(): void
    {
        // arrange
        $type = new FloatType();
        $collectionItem = 45.3;

        // act
        $isValid = $type->isValid($collectionItem);

        // assert
        $this->assertTrue($isValid);
    }

    public function testIsValid_CollectionItemHasInvalidType_ReturnsFalse(): void
    {
        // arrange
        $type = new FloatType();
        $invalidCollectionItem = 'test';

        // act
        $isValid = $type->isValid($invalidCollectionItem);

        // assert
        $this->assertFalse($isValid);
    }

    public function testToString_ParseTypeToString_ReturnsExpectedTypeName(): void
    {
        // arrange
        $type = new FloatType();

        // act
        $typeName = (string)$type;

        // assert
        $expectedTypeName = 'float';
        $this->assertSame($expectedTypeName, $typeName);
    }

    public function testIsEqual_CompareFloatTypeToDifferentType_ReturnsFalse(): void
    {
        // arrange
        $type = new FloatType();
        $differentType = new IntegerType();

        // act
        $isEqual = $type->isEqual($differentType);

        // assert
        $this->assertFalse($isEqual);
    }

    public function testIsEqual_CompareFloatTypeToAnotherFloatType_ReturnsTrue(): void
    {
        // arrange
        $type = new FloatType();
        $sameType = new FloatType();

        // act
        $isEqual = $type->isEqual($sameType);

        // assert
        $this->assertTrue($isEqual);
    }
}