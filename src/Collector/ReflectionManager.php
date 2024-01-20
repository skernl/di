<?php
declare(strict_types=1);

namespace Skernl\Di\Collector;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

/**
 * @ReflectionManager
 * @\Skernl\Di\Source\ReflectionManager
 */
class ReflectionManager
{
    /**
     * @var array $storageRoom
     */
    static private array $storageRoom = [
        'class' => [],
        'method' => [],
        'property' => [],
    ];

    /**
     * @param string $className
     * @return ReflectionClass
     * @throws ReflectionException
     */
    static public function reflectClass(string $className): ReflectionClass
    {
        if (false === array_key_exists($className, static::$storageRoom ['class'])) {
            if (false === class_exists($className)
                && false === interface_exists($className)
                && false === trait_exists($className)
                && false === enum_exists($className)
            ) {
                throw new InvalidArgumentException(
                    sprintf('Class %d not exist', $className)
                );
            }
            static::$storageRoom ['class'] [$className] = new ReflectionClass($className);
        }
        return static::$storageRoom ['class'] [$className];
    }

    /**
     * @param string $className
     * @param string $methodName
     * @return mixed
     * @throws ReflectionException
     */
    static public function reflectMethod(string $className, string $methodName): ReflectionMethod
    {
        if (false === array_key_exists($methodName, static::$storageRoom ['method'] [$className])) {
            if (false === class_exists($className)
                && false === trait_exists($className)
                && false === enum_exists($className)
            ) {
                throw new InvalidArgumentException(
                    sprintf('Class %d not exist', $className)
                );
            }
            static::$storageRoom ['method'] [$className] [$methodName] = static::reflectClass($className)->getMethod($methodName);
        }

        return static::$storageRoom ['method'] [$className] [$methodName];
    }

    /**
     * @param string $className
     * @param string $propertyName
     * @return ReflectionProperty
     * @throws ReflectionException
     */
    static public function reflectProperty(string $className, string $propertyName): ReflectionProperty
    {
        if (false === array_key_exists($propertyName, static::$storageRoom ['property'] [$className])) {
            if (false === class_exists($className)
                && false === trait_exists($className)
                && false === enum_exists($className)
            ) {
                throw new InvalidArgumentException(
                    sprintf('Class %d not exist', $className)
                );
            }
            static::$storageRoom ['method'] [$className] [$propertyName] = static::reflectClass($className)->getProperty($propertyName);
        }

        return static::$storageRoom ['method'] [$className] [$propertyName];
    }

    /**
     * @param ReflectionProperty $property
     * @return mixed
     */
    static public function getPropertyDefaultValue(ReflectionProperty $property): mixed
    {
        return $property->getDefaultValue();
    }
}