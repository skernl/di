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
class ReflectionManager extends AbstractMetadataCollector
{
    /**
     * @param string $className
     * @return ReflectionClass
     */
    static public function reflectClass(string $className): ReflectionClass
    {
        if (self::notNullHas($className)) {
            return self::notNullGet($className);
        }
        if (class_exists($className) || interface_exists($className)) {
            return self::$storageRoom [self::$class] [$className] = new ReflectionClass($className);
        }
        throw new InvalidArgumentException(
            sprintf('Class %d not exist', $className)
        );
    }

    /**
     * @param string $className
     * @param string $methodName
     * @return ReflectionMethod
     * @throws InvalidArgumentException|ReflectionException
     */
    static public function reflectMethod(string $className, string $methodName): ReflectionMethod
    {
        $key = $className . '::' . $methodName;
        if (self::notNullHas($key)) {
            return self::notNullGet($key);
        }
        if (self::reflectClass($className)->hasMethod($methodName)) {
            return self::$storageRoom [self::$method] [$key] = self::reflectClass($className)->getMethod($methodName);
        }
        throw new InvalidArgumentException(
            sprintf('Class %s does not have method %s', $className, $methodName)
        );
    }

    /**
     * @param string $className
     * @return bool
     */
    public function isInstantiable(string $className): bool
    {
        return self::reflectClass($className)->isInstantiable();
    }

    /**
     * @param string $className
     * @param string $propertyName
     * @return ReflectionProperty
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    static public function reflectProperty(string $className, string $propertyName): ReflectionProperty
    {
        $key = $className . '::' . $propertyName;
        if (self::notNullHas($key)) {
            return self::notNullGet($key);
        }
        return self::$storageRoom [self::$property] [$key] = self::reflectClass($className)->getProperty($propertyName);
    }

    /**
     * @param ReflectionProperty $property
     * @return mixed
     */
    static public function getPropertyDefaultValue(ReflectionProperty $property): mixed
    {
        return $property->getDefaultValue();
    }

    /**
     * @param string $className
     * @return never
     */
    static protected function invalidArgumentException(string $className): never
    {
        throw new InvalidArgumentException(
            sprintf('Class %d not exist', $className)
        );
    }
}