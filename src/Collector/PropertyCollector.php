<?php
declare(strict_types=1);

namespace Skernl\Di\Collector;

/**
 * @PropertyCollector
 * @\Skernl\Di\Collector\PropertyCollector
 */
class PropertyCollector extends AbstractMetadataCollector
{
    static public function collect(
        string $class,
        string $property,
        string $annotation,
        mixed  $value
    ): void
    {
        $key = $class . '::' . $property;
        self::$storageRoom [self::$property] [$key] [$annotation] = $value;
    }
}