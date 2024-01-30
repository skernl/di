<?php
declare(strict_types=1);

namespace Skernl\Di\Collector;

/**
 * @AbstractMetadataCollector
 * @\Skernl\Di\Collector\AbstractMetadataCollector
 */
class MetadataCollector extends AbstractMetadataCollector
{
    static public function getAnnotation(string $annotation, string $class, mixed $default = null): mixed
    {
        return self::$storageRoom [self::$annotation] [$annotation] [$class] ?? $default;
    }

    static public function getAnnotations(string $annotation, mixed $default = null): mixed
    {
        return self::$storageRoom [self::$annotation] [$annotation] ?? $default;
    }

    static public function getClass(string $class, string $annotation, mixed $default = null)
    {
        return self::$storageRoom [self::$class] [$class] [$annotation] ?? $default;
    }

    static public function getClasses(string $class, mixed $default = null)
    {
        return self::$storageRoom [self::$class] [$class] ?? $default;
    }

    static public function getMethod(string $class, string $method, string $annotation, mixed $default = null)
    {
        return self::$storageRoom [self::$method] [$class] [$method] [$annotation] ?? $default;
    }

    static public function getMethods(string $class, mixed $default = null)
    {
        return self::$storageRoom [self::$method] [$class] ?? $default;
    }
}