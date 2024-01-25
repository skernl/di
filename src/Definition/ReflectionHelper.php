<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

/**
 * @ReflectionHelper
 * @\Skernl\Di\Definition\ReflectionHelper
 */
class ReflectionHelper
{
    /**
     * @param string $className
     * @return ReflectionClass
     */
    static public function reflectClass(string $className): ReflectionClass
    {
        if (class_exists($className) || interface_exists($className)) {
            return new ReflectionClass($className);
        }
        throw new InvalidArgumentException(
            sprintf('Class %d not exist', $className)
        );
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param string $methodName
     * @return ReflectionMethod
     */
    static public function reflectMethod(ReflectionClass $reflectionClass, string $methodName): ReflectionMethod
    {
        if ($reflectionClass->hasMethod($methodName)) {
            return $reflectionClass->getMethod($methodName);
        }
        throw new InvalidArgumentException(
            sprintf(
                'Class %s does not have method %s',
                $reflectionClass->getName(),
                $methodName
            )
        );
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return bool
     */
    public function isInstantiable(ReflectionClass $reflectionClass): bool
    {
        return $reflectionClass->isInstantiable();
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param string $propertyName
     * @return ReflectionProperty
     * @throws ReflectionException
     */
    static public function reflectProperty(ReflectionClass $reflectionClass, string $propertyName): ReflectionProperty
    {
        return $reflectionClass->getProperty($propertyName);
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