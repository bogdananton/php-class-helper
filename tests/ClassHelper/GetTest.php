<?php
namespace tests\ClassHelper;

class GetTest extends \PHPUnit_Framework_TestCase
{
    protected $instance;

    public function setUp()
    {
        $this->instance = \ClassHelper::instance(new UnderTestGet());
    }

    /**
     * Will update property value.
     *
     * @dataProvider dataProviderPropertyNames
     * @param string $properyName
     * @param mixed $value
     */
    public function testWillUpdatePublicPropertyValue($properyName, $value)
    {
        $response = $this->instance->{$properyName};
        static::assertEquals($value, $response);
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
    public function testWhenThePropertyDoesntExistThenThrowException()
    {
        $this->instance->prop3;
    }
}

class UnderTestGet
{
    public $prop0 = 0;
    protected $prop1 = 2;
    private $prop2 = 4;

    public function __get($name)
    {
        if ($name === 'prop4') {
            return 8;
        }
    }
}
