<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionAttribute;
use ReflectionClass;
use Skernl\Di\Collector\ClassCollector;

/**
 * @ObjectDefinition
 * @\Skernl\Di\Definition\ObjectDefinition
 */
class ObjectDefinition implements DefinitionInterface
{
    /**
     * @var string $className
     */
    private string $className;

    /**
     * @param ReflectionClass $reflectionClass
     */
    public function __construct(private readonly ReflectionClass $reflectionClass)
    {
        $this->collect();
    }

    public function getParameters(string $methodName)
    {
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        isset($this->className) || $this->className = $this->reflectionClass->getName();
        return $this->className;
    }

    /**
     * @return void
     */
    private function collect(): void
    {
        $this->collectClass();
        $this->collectMethod();
        $this->collectProperty();
    }

    /**
     * @return void
     */
    private function collectClass(): void
    {
        $attributes = $this->reflectionClass->getAttributes();
        foreach ($attributes as $attribute) {
            $arguments = $attribute->getArguments();
            ClassCollector::collectClass(
                $this->getClassName(), $arguments
            );
        }
    }

    private function collectMethod(): void
    {
        $methods = $this->reflectionClass->getMethods();
        foreach ($methods as $method) {
            $arguments = $method->getAttributes();
            ClassCollector::collectClass(
                $this->getClassName(), $arguments
            );
        }
    }

    /**
     * @return void
     */
    private function collectProperty(): void
    {
        $properties = $this->reflectionClass->getProperties();
        foreach ($properties as $property) {
            $arguments = $property->getAttributes();
            ClassCollector::collectClass(
                $this->getClassName(), $arguments
            );
        }
    }
}