<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

/**
 * @MetadataCollector
 * @\Skernl\Di\Source\MetadataCollector
 */
class MetadataCollector
{
    /**
     * @var array $retailer
     */
    static protected array $retailer = [];

    static public function get(string $className)
    {
        if () {}
        return self::$retailer [$className] ??= ReflectionManager::reflectClass($className);
    }
}