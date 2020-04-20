<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Tests\Type;

use Adrmrn\SimpleCollections\Type\BooleanType;
use Adrmrn\SimpleCollections\Type\IntegerType;
use PHPUnit\Framework\TestCase;

class BooleanTypeTest extends TestCase
{
    public function testIsValid_CollectionItemIsTypeOfBoolean_ReturnsTrue(): void
    {
        // arrange
        $type = new BooleanType();
        $collectionItem = true;

        // act
        $isValid = $type->isValid($collectionItem);

        // assert
        $this->assertTrue($isValid);
    }

    public function testIsValid_CollectionItemHasInvalidType_ReturnsFalse(): void
    {
        // arrange
        $type = new BooleanType();
        $invalidCollectionItem = 'test';

        // act
        $isValid = $type->isValid($invalidCollectionItem);

        // assert
        $this->assertFalse($isValid);
    }

    public function testToString_ParseTypeToString_ReturnsExpectedTypeName(): void
    {
        // arrange
        $type = new BooleanType();

        // act
        $typeName = (string)$type;

        // assert
        $expectedTypeName = 'boolean';
        $this->assertSame($expectedTypeName, $typeName);
    }

    public function testIsEqual_CompareBooleanTypeToDifferentType_ReturnsFalse(): void
    {
        // arrange
        $type = new BooleanType();
        $differentType = new IntegerType();

        // act
        $isEqual = $type->isEqual($differentType);

        // assert
        $this->assertFalse($isEqual);
    }

    public function testIsEqual_CompareBooleanTypeToAnotherBooleanType_ReturnsTrue(): void
    {
        // arrange
        $type = new BooleanType();
        $sameType = new BooleanType();

        // act
        $isEqual = $type->isEqual($sameType);

        // assert
        $this->assertTrue($isEqual);
    }
}