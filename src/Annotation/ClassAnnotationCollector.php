<?php
declare(strict_types=1);

namespace Skernl\Di\Annotation;

/**
 * @ClassAnnotationCollector
 * @\Skernl\Di\Annotation\ClassAnnotationCollector
 */
class ClassAnnotationCollector
{
    /**
     * @var array $retailer
     */
    protected array $storageRoom = [];

    /**
     * @param string $class
     * @param string $property
     * @return mixed
     */
    public function getProperty(string $class, string $property): mixed
    {
        return $this->storageRoom [$class] [2] [$property];
    }

    /**
     * @param string $class
     * @return mixed
     */
    public function getAllProperty(string $class): mixed
    {
        return $this->storageRoom [$class] [2];
    }


    /**
     * @param string $class
     * @param string $annotation
     * @param mixed $value
     * @return void
     */
    public function collectClass(
        string $class,
        string $annotation,
        mixed  $value
    ): void
    {
        $this->storageRoom [$class] [0] [$annotation] = $value;
    }

    /**
     * @param string $class
     * @param string $method
     * @param string $annotation
     * @param mixed $value
     * @return void
     */
    public function collectMethod(
        string $class,
        string $method,
        string $annotation,
        mixed  $value
    ): void
    {
        $this->storageRoom [$class] [1] [$method] [$annotation] = $value;
    }

    /**
     * @param string $class
     * @param string $property
     * @param string $annotation
     * @param mixed $value
     * @return void
     */
    public function collectProperty(
        string $class,
        string $property,
        string $annotation,
        mixed  $value
    ): void
    {
        $this->storageRoom [$class] [2] [$property] [$annotation] = $value;
    }
}