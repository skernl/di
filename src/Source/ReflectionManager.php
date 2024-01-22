<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

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
    static private array $storageRoom = [];

    /**
     * @param string $className
     * @return ReflectionClass
     */
    static public function reflectClass(string $className): ReflectionClass
    {
        if (isset(self::$storageRoom [$className])) {
            return self::$storageRoom [$className];
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
     * @return mixed
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    static public function reflectMethod(string $className, string $methodName): ReflectionMethod
    {
        $key = $className . '::' . $methodName . ':method';
        if (isset(self::$storageRoom [$key])) {
            return self::$storageRoom [$key];
        }
        return self::$storageRoom [$key]
            = self::reflectClass($className)->getMethod($methodName);
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
        if (isset(self::$storageRoom [$propertyName])) {
            return self::$storageRoom [$key];
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
     * @param string $methodName
     * @return array
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    static public function getMethodParameters(string $className, string $methodName): array
    {
        $key = $className . '::' . $methodName . ':parameter';
        if (isset(self::$storageRoom [$key])) {
            return self::$storageRoom [$key];
        }
        $parameters = self::reflectMethod($className, $methodName)->getParameters();
        $defaultParameters = [];
        foreach ($parameters as $parameter) {
            $type = $parameter->getType()->getName();
            $defaultParameters [] = match ($type) {
                'bool', 'int', 'float', 'string', 'array' => function () use ($type, $parameter) {
                    $param = [
                        'type' => $type,
                        'name' => $parameter->getName(),
                        'allowsNull' => $parameter->allowsNull(),
                    ];
                    $parameter->isDefaultValueAvailable()
                    && $param ['defaultValue'] = $parameter->getDefaultValue();
                    return $param;
                },
                default => [
                    'type' => 'object',
                    'name' => $parameter->getName(),
                    'allowsNull' => $parameter->allowsNull(),
                ]
            };
        }
        return self::$storageRoom [$key] = $defaultParameters;
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