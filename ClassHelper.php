<?php
class ClassHelper
{
    protected $origin;

    /** @var ReflectionClass */
    protected $target;

    /**
     * Creates and returns the wrapper.
     * Only objects are allowed to be passed, else an exception will be thrown.
     * Store the input object to the created wrapper.
     *
     * @param $object
     *
     * @return Helper
     */
    public static function instance($object)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('Only objects are allowed to be passed to the helper.');
        }

        $response = new self();
        $response->origin = $object;
        $response->target = new ReflectionClass($object);
        return $response;
    }

    public function __get($name)
    {
        $property = $this->getProperty($name);
        $value = $property->getValue($this->origin);
        return $value;
    }

    public function __set($name, $value)
    {
        $property = $this->getProperty($name);
        $property->setValue($this->origin, $value);
        return true;
    }

    protected function getProperty($name)
    {
        if (!$this->target->hasProperty($name)) {
            $message = sprintf('Property not found on object %s.', get_class($this->origin));
            throw new OutOfBoundsException($message);
        }

        /** @var ReflectionProperty $property */
        $property = $this->target->getProperty($name);
        $property->setAccessible(true);

        return $property;
    }

    public function call($name, array $args = [])
    {
        if (!$this->target->hasMethod($name)) {
            $message = sprintf('Method not found on object %s.', get_class($this->origin));
            throw new BadMethodCallException($message);
        }

        $method = $this->target->getMethod($name);
        $method->setAccessible(true);
        $response = $method->invokeArgs($this->origin, $args);

        return $response;
    }
}
