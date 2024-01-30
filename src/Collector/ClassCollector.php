<?php
declare(strict_types=1);

namespace Skernl\Di\Collector;

/**
 * @ClassCollector
 * @\Skernl\Di\Collector\ClassCollector
 */
class ClassCollector extends AbstractMetadataCollector
{
    static public function collect(
        string $class,
        string $annotation,
        mixed  $value
    ): void
    {
        self::$storageRoom [self::$class] [$class] [$annotation] = $value;
    }
}