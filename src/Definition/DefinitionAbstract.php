<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionClass;

abstract class DefinitionAbstract
{
    protected string $class;
    protected ReflectionClass $reflectionClass;
    protected string $classCategory;
    protected bool $instantiable = false;

    /**
     * @param ReflectionClass $reflectionClass
     * @return void
     */
    public function init(ReflectionClass $reflectionClass): void
    {
        $this->class = $reflectionClass->getName();
        $this->reflectionClass = $reflectionClass;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->class;
    }

    /**
     * @return bool
     */
    public function isInstantiable(): bool
    {
        return $this->instantiable;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->classCategory;
    }
}