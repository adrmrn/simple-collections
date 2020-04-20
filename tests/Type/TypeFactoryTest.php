<?php
declare(strict_types=1);

namespace Adrmrn\SimpleCollections\Tests\Type;

use Adrmrn\SimpleCollections\Exception\UnsupportedCollectionTypeException;
use Adrmrn\SimpleCollections\Tests\Fake\ExampleClass;
use Adrmrn\SimpleCollections\Type;
use Adrmrn\SimpleCollections\Type\ArrayType;
use Adrmrn\SimpleCollections\Type\BooleanType;
use Adrmrn\SimpleCollections\Type\FloatType;
use Adrmrn\SimpleCollections\Type\IntegerType;
use Adrmrn\SimpleCollections\Type\ObjectType;
use Adrmrn\SimpleCollections\Type\StringType;
use Adrmrn\SimpleCollections\Type\TypeFactory;
use PHPUnit\Framework\TestCase;

class TypeFactoryTest extends TestCase
{
    public function testCreateFromString_CreateTypeFromClassName_ReturnsExpectedTypeObject(): void
    {
        // arrange
        $className = ExampleClass::class;

        // act
        $typeObject = TypeFactory::createFromString($className);

        // assert
        $expectedTypeObject = new ObjectType($className);
        $this->assertEquals($expectedTypeObject, $typeObject);
    }

    public function testCreateFromString_CreateTypeFromInterfaceName_ReturnsExpectedTypeObject(): void
    {
        // arrange
        $interfaceName = \DateTimeInterface::class;

        // act
        $typeObject = TypeFactory::createFromString($interfaceName);

        // assert
        $expectedTypeObject = new ObjectType($interfaceName);
        $this->assertEquals($expectedTypeObject, $typeObject);
    }

    /**
     * @dataProvider scalarTypesProvider
     */
    public function testCreateFromString_CreateTypeFromString_ReturnsExpectedTypeObject(
        string $typeAsString,
        Type $expectedTypeObject
    ): void {
        // act
        $typeObject = TypeFactory::createFromString($typeAsString);

        // assert
        $this->assertEquals($expectedTypeObject, $typeObject);
    }

    public function scalarTypesProvider(): array
    {
        // [type name, expected type object]
        return [
            ['array', new ArrayType()],
            ['bool', new BooleanType()],
            ['boolean', new BooleanType()],
            ['float', new FloatType()],
            ['double', new FloatType()],
            ['int', new IntegerType()],
            ['integer', new IntegerType()],
            ['string', new StringType()],
        ];
    }

    public function testCreateFromString_TryCreateUnsupportedType_ThrownException(): void
    {
        // arrange
        $unsupportedType = 'test';

        // assert
        $this->expectException(UnsupportedCollectionTypeException::class);

        // act
        TypeFactory::createFromString($unsupportedType);
    }
}