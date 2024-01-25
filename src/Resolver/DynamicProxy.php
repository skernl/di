<?php
declare(strict_types=1);

namespace Skernl\Di\Resolver;

use InvalidArgumentException;
use ReflectionException;
use Skernl\Di\Contract\ProxyInterface;

/**
 * When I wrote this,only God and I understood what I was doing.
 *
 * @DynamicProxy
 * @\Skernl\Di\Collector\DynamicProxy
 */
final class DynamicProxy implements ProxyInterface
{
    /**
     * @var object $instance
     */
    static protected object $instance;

    public function __construct(object $instance)
    {
        self::$instance = $instance;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([self::$instance, $name], array_values($arguments));
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    static public function __callStatic(string $name, array $arguments)
    {
        if (false === method_exists(self::$instance, $name)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Method %d of Class %d does not exist',
                    $name,
                    get_class(self::$instance)
                )
            );
        }

        return self::$instance::{$name}(... $arguments);
    }

    /**
     * @return mixed|object
     * @throws ReflectionException
     */
    public function __clone()
    {
        if (true === method_exists(self::$instance, '__clone')) {
            return call_user_func([self::$instance, '__clone']);
        }
        return clone self::$instance;
    }
}