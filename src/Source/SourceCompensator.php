<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

use ReflectionClass;

/**
 * @SourceCompensator
 * @\Skernl\Di\Source\SourceCompensator
 */
class SourceCompensator
{
    private $metadataCollect;

    private string $className;

    public function __construct(private readonly ReflectionClass $reflectionClass)
    {
        $this->collector();
    }

    public function getClassName(): string
    {
        if (isset($this->className)) {
            $this->className = $this->reflectionClass->getName();
        }
        return $this->className;
    }

    private function collector()
    {
    }
}