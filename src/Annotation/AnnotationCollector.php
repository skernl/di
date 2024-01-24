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
    static public function collectClass(
        string $class,
        string $annotation,
        mixed  $value
    ): void
    {
        static::$storageRoom [$class] [0] [$annotation] = $value;
    }

    /**
     * @param string $class
     * @param string $method
     * @param string $annotation
     * @param mixed $value
     * @return void
     */
    static public function collectMethod(
        string $class,
        string $method,
        string $annotation,
        mixed  $value
    ): void
    {
        static::$storageRoom [$class] [1] [$method] [$annotation] = $value;
    }

    /**
     * @param string $class
     * @param string $property
     * @param string $annotation
     * @param mixed $value
     * @return void
     */
    static public function collectProperty(
        string $class,
        string $property,
        string $annotation,
        mixed  $value
    ): void
    {
        static::$storageRoom [$class] [2] [$property] [$annotation] = $value;
    }
}