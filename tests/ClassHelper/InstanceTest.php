<?php
namespace tests\ClassHelper;

class InstanceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When the input is not an object then throw exception.
     *
     * @param mixed $input
     * @dataProvider dataProviderNonObjects
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Only objects are allowed to be passed to the helper.
     */
    public function testWhenTheInputIsNotAnObjectThenThrowException($input)
    {
        \ClassHelper::instance($input);
    }

    /**
     * Will return an instance of ProtectedHelper.
     */
    public function testWillReturnAnInstanceOfProtectedHelper()
    {
        $response = \ClassHelper::instance(new \stdClass());
        static::assertInstanceOf(\ClassHelper::class, $response);
    }

    /**
     * Will store the input object as the origin.
     */
    public function testWillStoreTheInputObjectAsTheOrigin()
    {
        $input = new \stdClass();
        $response = \ClassHelper::instance($input);

        $value = \PHPUnit_Framework_Assert::readAttribute($response, 'origin');
        static::assertSame($input, $value);
    }

    /**
     * Will store a reflectionclass of the object in the target attribute.
     */
    public function testWillStoreAReflectionclassOfTheObjectInTheTargetAttribute()
    {
        $input = new \BadMethodCallException();
        $response = \ClassHelper::instance($input);

        /** @var \ReflectionClass $value */
        $value = \PHPUnit_Framework_Assert::readAttribute($response, 'target');
        static::assertInstanceOf(\ReflectionClass::class, $value);
        static::assertEquals('BadMethodCallException', $value->getName());
    }

    public function dataProviderNonObjects()
    {
        return [
            [null],
            ['string'],
            [1001],
            [[]],
            [false],
        ];
    }
}
