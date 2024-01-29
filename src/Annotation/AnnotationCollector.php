<?php
declare(strict_types=1);

namespace Skernl\Di\Annotation;

use Skernl\Di\Collector\AbstractMetadataCollector;

/**
 * @AnnotationCollector
 * @\Skernl\Di\Annotation\AnnotationCollector
 */
class AnnotationCollector extends AbstractMetadataCollector
{
    /**
     * @var array $retailer
     */
    static protected array $storageRoom = [];

    /**
     * @param string $class
     * @param string $annotation
     * @param mixed $value
     * @return void
     */
    static public function collect(
        string $annotation,
        string $class,
        mixed  $value
    ): void
    {
        self::$storageRoom [$annotation] [$class] = $value;
    }

    static public function list(null|string $annotation = null): array
    {
        if (null === $annotation) {
            return self::$storageRoom;
        }
        return self::$storageRoom [$annotation] ?: [];
    }
}