<?php
namespace tests\ClassHelper;

class CallTest extends \PHPUnit_Framework_TestCase
{
    /** @var \UnderTestCall */
    protected $origin;

    /** @var \ClassHelper */
    protected $instance;

    public function setUp()
    {
        $this->origin = new UnderTestCall();
        $this->instance = \ClassHelper::instance($this->origin);
    }

    /**
     * Calls method and value.
     *
     * @dataProvider dataProviderExistingMethods
     *
     * @param string $methodName
     * @param string $expectedValue
     */
    public function testCallsPrivateMethodAndValue($methodName, $expectedValue)
    {
        $value = $this->instance->call($methodName);
        static::assertEquals($expectedValue, $value);
    }

    public function dataProviderExistingMethods()
    {
        return [
            ['getPublic', '[public-value]'],
            ['getProtected', '[protected-value]'],
            ['getPrivate', '[private-value]'],
        ];
    }

    /**
     * When the method doesn't exist then throw exception.
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Method not found on object tests\ClassHelper\UnderTestCall.
     */
    public function testWhenTheMethodDoesnTExistThenThrowException()
    {
        $this->instance->call('getNonexistingMethod');
    }
}

class UnderTestCall
{
    public function getPublic()
    {
        return '[public-value]';
    }

    protected function getProtected()
    {
        return '[protected-value]';
    }

    private function getPrivate()
    {
        return '[private-value]';
    }
}