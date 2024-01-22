<?php
declare(strict_types=1);

namespace Skernl\Di\Resolver;

use InvalidArgumentException;
use ReflectionException;
use Skernl\Di\Collector\ReflectionManager;

/**
 * @DynamicProxy
 * @\Skernl\Di\Collector\DynamicProxy
 */
final class DynamicProxy
{
    /**
     * @var string $className
     */
    static private string $className;

    /**
     * @var object $instance
     */
    static private object $instance;

    /**
     * @param string $className
     * @throws ReflectionException
     */
    public function __construct(string $className)
    {
        DynamicProxy::$className = $className;
        self::$instance = ReflectionManager::reflectClass($className)->newInstance();
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        if (false === method_exists(DynamicProxy::$instance, $name)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Method %d of Class %d does not exist',
                    $name,
                    DynamicProxy::$className
                )
            );
        }

        return call_user_func_array([DynamicProxy::$instance, $name], array_values($arguments));
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    static public function __callStatic(string $name, array $arguments)
    {
        if (false === method_exists(DynamicProxy::$instance, $name)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Method %d of Class %d does not exist',
                    $name,
                    DynamicProxy::$className
                )
            );
        }

        return DynamicProxy::$instance::{$name}(... $arguments);
    }

    /**
     * @return mixed|object
     * @throws ReflectionException
     */
    public function __clone()
    {
        if (true === method_exists(DynamicProxy::$instance, '__clone')) {
            return call_user_func([DynamicProxy::$instance, '__clone']);
        }
        return clone DynamicProxy::$instance;
    }
}