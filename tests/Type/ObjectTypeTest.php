<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Tests\Type;

use Adrmrn\SimpleCollections\Exception\UnsupportedCollectionTypeException;
use Adrmrn\SimpleCollections\Tests\Fake\ExampleClass;
use Adrmrn\SimpleCollections\Type\IntegerType;
use Adrmrn\SimpleCollections\Type\ObjectType;
use PHPUnit\Framework\TestCase;

class ObjectTypeTest extends TestCase
{
    public function testCreation_TryCreateObjectTypeOfClassThatDoesNotExist_ThrownException(): void
    {
        // arrange
        $invalidClassName = 'Class\\Does\\Not\\Exist';

        // assert
        $this->expectException(UnsupportedCollectionTypeException::class);

        // act
        new ObjectType($invalidClassName);
    }

    public function testIsValid_ObjectTypeHasDefinedTypeOfInterfaceAndItemIsInstanceOfThatInterface_ReturnsTrue(): void
    {
        // arrange
        $interfaceName = \DateTimeInterface::class;
        $type = new ObjectType($interfaceName);
        $collectionItem = new \DateTimeImmutable('2020-01-01 10:00:00');

        // act
        $isValid = $type->isValid($collectionItem);

        // assert
        $this->assertTrue($isValid);
    }

    public function testIsValid_CollectionItemHasValidType_ReturnsTrue(): void
    {
        // arrange
        $type = new ObjectType(ExampleClass::class);
        $collectionItem = new ExampleClass();

        // act
        $isValid = $type->isValid($collectionItem);

        // assert
        $this->assertTrue($isValid);
    }

    public function testIsValid_CollectionItemHasInvalidType_ReturnsFalse(): void
    {
        // arrange
        $type = new ObjectType(ExampleClass::class);
        $invalidCollectionItem = 'test';

        // act
        $isValid = $type->isValid($invalidCollectionItem);

        // assert
        $this->assertFalse($isValid);
    }

    public function testToString_ParseTypeToString_ReturnsExpectedTypeName(): void
    {
        // arrange
        $type = new ObjectType(ExampleClass::class);

        // act
        $typeName = (string)$type;

        // assert
        $expectedTypeName = ExampleClass::class;
        $this->assertSame($expectedTypeName, $typeName);
    }

    public function testIsEqual_CompareObjectTypeToDifferentType_ReturnsFalse(): void
    {
        // arrange
        $type = new ObjectType(ExampleClass::class);
        $differentType = new IntegerType();

        // act
        $isEqual = $type->isEqual($differentType);

        // assert
        $this->assertFalse($isEqual);
    }

    public function testIsEqual_CompareObjectTypeToAnotherObjectType_ReturnsTrue(): void
    {
        // arrange
        $type = new ObjectType(ExampleClass::class);
        $sameType = new ObjectType(ExampleClass::class);

        // act
        $isEqual = $type->isEqual($sameType);

        // assert
        $this->assertTrue($isEqual);
    }

    public function testIsEqual_CompareObjectTypeToAnotherObjectTypeOfDifferentClassName_ReturnsFalse(): void
    {
        // arrange
        $type = new ObjectType(ExampleClass::class);
        $differentType = new ObjectType(\DateTimeInterface::class);

        // act
        $isEqual = $type->isEqual($differentType);

        // assert
        $this->assertFalse($isEqual);
    }
}