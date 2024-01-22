<?php
declare(strict_types=1);

namespace Skernl\Di\Collector;

use InvalidArgumentException;
use ReflectionException;
use Skernl\Di\Source\ReflectionManager;

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
     */
    public function __construct(string $className)
    {
        static::$className = $className;
        self::$instance = ReflectionManager::reflectClass($className)->newInstance();
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        if (false === method_exists(static::$instance, $name)) {
            throw new InvalidArgumentException(
                sprintf('Method %d of Class %d does not exist', $name, static::$className)
            );
        }

        return call_user_func_array([static::$instance, $name], array_values($arguments));
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    static public function __callStatic(string $name, array $arguments)
    {
        if (false === method_exists(static::$instance, $name)) {
            throw new InvalidArgumentException(
                sprintf('Method %d of Class %d does not exist', $name, static::$className)
            );
        }

        return static::$instance::{$name}(... $arguments);
    }

    /**
     * @return mixed|object
     * @throws ReflectionException
     */
    public function __clone()
    {
        if (true === method_exists(static::$instance, '__clone')) {
            return call_user_func([static::$instance, '__clone']);
        }
        return clone static::$instance;
    }
}