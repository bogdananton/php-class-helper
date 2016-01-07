<?php
namespace tests\ClassHelper;

class SetTest extends \PHPUnit_Framework_TestCase
{
    protected $origin;
    protected $instance;

    public function setUp()
    {
        $this->origin = new UnderTestGet();
        $this->instance = \ClassHelper::instance($this->origin);
    }

    /**
     * Will update property value.
     *
     * @dataProvider dataProviderPropertyNames
     * @param $propertyName
     */
    public function testWillUpdatePublicPropertyValue($propertyName)
    {
        $number = rand(1, 10);
        $this->instance->{$propertyName} = $number;
        $value = \PHPUnit_Framework_Assert::readAttribute($this->origin, $propertyName);
        static::assertEquals($number, $value);
    }

    public function dataProviderPropertyNames()
    {
        return [
            ['prop0', 0, 'public'],
            ['prop1', 2, 'protected'],
            ['prop2', 4, 'private'],
        ];
    }

    /**
     * When the property doesn't exist then throw exception.
     * @expectedException \OutOfBoundsException
     * @expectedExceptionMessage Property not found on object tests\ClassHelper\UnderTestGet.
     */
    public function testWhenThePropertyDoesnTExistThenThrowException()
    {
        $this->instance->prop3 = 1;
    }
}

class UnderTestSet
{
    public $prop0 = 0;
    protected $prop1 = 2;
    private $prop2 = 4;
}
