<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionClass;

/**
 * @SourceManager
 * @\Skernl\Di\Definition\SourceManager
 */
class SourceManager
{
    private array $source = [];

    /**
     * @param array $classMap
     */
    public function __construct(array $classMap)
    {
        $this->normalize($classMap);
    }

    /**
     * @param string $class
     * @return ReflectionClass|null
     */
    public function getSource(string $class): ReflectionClass|null
    {
        return $this->source [$class] ?? null;
    }

    /**
     * @param array $source
     * @return void
     */
    private function normalize(array $source = []): void
    {
        $class = array_shift($source);
        (interface_exists($class)
            || class_exists($class)
            || trait_exists($class)
            || enum_exists($class)
        ) && $this->source [] = new ReflectionClass($class);
        empty($source) || $this->normalize($source);
    }
}