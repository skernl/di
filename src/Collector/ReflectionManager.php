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
     * @var string $keyName
     */
    protected static string $keyName = 'classes';

    /**
     * @param string $className
     * @return ReflectionClass
     */
    static public function reflectClass(string $className): ReflectionClass
    {
        if (self::notNullHas($className)) {
            return self::notNullGet($className);
        }
        if (class_exists($className)
            || interface_exists($className)
            || trait_exists($className)
            || enum_exists($className)
        ) {
            return self::$storageRoom [$className] = new ReflectionClass($className);
        }
        self::invalidArgumentException($className);
    }

    /**
     * @param string $className
     * @param string $methodName
     * @return ReflectionMethod
     * @throws ReflectionException
     */
    static public function reflectMethod(string $className, string $methodName): ReflectionMethod
    {
        $key = $className . '::' . $methodName . ':method';
        if (self::notNullHas($key)) {
            return self::notNullGet($key);
        }
        return self::$storageRoom [$key]
            = self::reflectClass($className)->getMethod($methodName);
    }

    static public function getAll()
    {
        var_dump(self::$storageRoom);
    }

//    /**
//     * @param string $className
//     * @return array
//     * @throws InvalidArgumentException
//     */
//    static public function reflectMethods(string $className): array
//    {
//        return self::reflectClass($className)->getMethods();
//    }

    /**
     * @param string $className
     * @param string $propertyName
     * @return ReflectionProperty
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    static public function reflectProperty(string $className, string $propertyName): ReflectionProperty
    {
        $key = $className . '::' . $propertyName . ':property';
        if (self::notNullHas($key)) {
            return self::notNullGet($key);
        }
        return self::$storageRoom [$key]
            = self::reflectClass($className)->getProperty($propertyName);
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