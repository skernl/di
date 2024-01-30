<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

use InvalidArgumentException;
use Psr\Container\{
    ContainerExceptionInterface,
    NotFoundExceptionInterface,
};
use ReflectionException;
use Skernl\Contract\ContainerInterface;

/**
 * When I wrote this,only God and I understood what I was doing.
 *
 * @DynamicProxy
 * @\Skernl\Di\Collector\DynamicProxy
 */
trait DynamicProxy
{
    /**
     * @var object $instance
     */
    static private object $instance;

    /**
     * @param object $object
     */
    public function __construct(object $object)
    {
        self::$instance = $object;
    }

    public function __destruct()
    {
        if (method_exists(self::$instance, '__destruct')) {
            self::$instance->__destruct();
        }
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        if (!method_exists(self::$instance, $name)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Method %s does not exist in Class %s',
                    $name,
                    get_parent_class(self::$instance)
                )
            );
        }
        return self::$instance->{$name}(... $arguments);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    static public function __callStatic(string $name, array $arguments)
    {
        if (method_exists(self::$instance, '__callStatic')) {
            return self::$instance::__callStatic($name, $arguments);
        }
        throw new InvalidArgumentException(
            sprintf(
                'Method %s does not exist in Class %s',
                $name,
                get_parent_class(self::$instance)
            )
        );
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        if (method_exists(self::$instance, '__get')) {
            return self::$instance::__get($name);
        }
        return self::$instance->__get($name);
    }

    public function __set(string $name, mixed $value)
    {
        if (method_exists(self::$instance, '__set')) {
            self::$instance->__set($name, $value);
        }
        self::$instance->__set($name, $value);
    }

    /**
     * @return mixed|object
     * @throws ReflectionException
     */
    public function __clone()
    {
        return call_user_func([self::$instance, '__clone']);
    }
}