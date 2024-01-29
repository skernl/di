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
}