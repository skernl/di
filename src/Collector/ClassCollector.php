<?php
declare(strict_types=1);

namespace Skernl\Di\Collector;

use ReflectionAttribute;
use ReflectionClass;
use Skernl\Di\Contract\CollectorInterface;

/**
 * @ClassCollector
 * @\Skernl\Di\Scheduler\ClassCollector
 */
class ClassCollector implements CollectorInterface
{
    private string $className;

    protected bool $instantiable;

    public function __construct(protected ReflectionClass $reflectionClass)
    {
        $this->className = $this->reflectionClass->getName();
        $this->instantiable = $this->reflectionClass->isInstantiable();
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function isInstantiable(): bool
    {
        return $this->instantiable;
    }

    /**
     * @return ReflectionAttribute[]
     */
    public function getClassAnnotations(): array
    {
        return $this->reflectionClass->getAttributes();
    }

    public function getProperties(): array
    {
        // TODO: Implement getProperties() method.
    }

    public function getMethodParameters(): array
    {
        // TODO: Implement getMethodParameters() method.
    }

    public function hasMethod(string $method): bool
    {
        return $this->reflectionClass->hasMethod($method);
    }
}