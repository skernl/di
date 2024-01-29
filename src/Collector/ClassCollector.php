<?php
declare(strict_types=1);

namespace Skernl\Di\Collector;

/**
 * @ClassCollector
 * @\Skernl\Di\Collector\ClassCollector
 */
class ClassCollector extends AbstractMetadataCollector
{
    static public function collectClass(string $class, array $annotation = []): void
    {
        self::$storageRoom [self::$class] [$class] = $annotation;
    }

    static public function collectMethod(string $class, string $method, array $annotation = []): void
    {
        self::$storageRoom [self::$method] [$class . '::' . $method] = $annotation;
    }

    static public function collectProperty(string $class, string $property, array $annotation = []): void
    {
        self::$storageRoom [self::$property] [$class . '::' . $property] = $annotation;
    }

    public function getCollectClass()
    {
    }

    static public function collect(
        string $class,
        string $annotation,
        mixed  $value
    ): void
    {
        self::$storageRoom [self::$class] [$class] [$annotation] = $value;
    }

    static public function list(null|string $annotation = null): array
    {
        if (null === $annotation) {
            return self::$storageRoom [self::$class];
        }
        return self::$storageRoom [self::$class] [$annotation] ?: [];
    }
}