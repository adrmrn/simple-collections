<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Tests\Type;

use Adrmrn\SimpleCollections\Type\IntegerType;
use Adrmrn\SimpleCollections\Type\StringType;
use PHPUnit\Framework\TestCase;

class StringTypeTest extends TestCase
{
    public function testIsValid_CollectionItemIsTypeOfString_ReturnsTrue(): void
    {
        // arrange
        $type = new StringType();
        $collectionItem = 'test';

        // act
        $isValid = $type->isValid($collectionItem);

        // assert
        $this->assertTrue($isValid);
    }

    public function testIsValid_CollectionItemHasInvalidType_ReturnsFalse(): void
    {
        // arrange
        $type = new StringType();
        $invalidCollectionItem = 5;

        // act
        $isValid = $type->isValid($invalidCollectionItem);

        // assert
        $this->assertFalse($isValid);
    }

    public function testToString_ParseTypeToString_ReturnsExpectedTypeName(): void
    {
        // arrange
        $type = new StringType();

        // act
        $typeName = (string)$type;

        // assert
        $expectedTypeName = 'string';
        $this->assertSame($expectedTypeName, $typeName);
    }

    public function testIsEqual_CompareStringTypeToDifferentType_ReturnsFalse(): void
    {
        // arrange
        $type = new StringType();
        $differentType = new IntegerType();

        // act
        $isEqual = $type->isEqual($differentType);

        // assert
        $this->assertFalse($isEqual);
    }

    public function testIsEqual_CompareStringTypeToAnotherStringType_ReturnsTrue(): void
    {
        // arrange
        $type = new StringType();
        $sameType = new StringType();

        // act
        $isEqual = $type->isEqual($sameType);

        // assert
        $this->assertTrue($isEqual);
    }
}