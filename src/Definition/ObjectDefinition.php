<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionClass;
use Skernl\Di\Annotation\AnnotationCollector;
use Skernl\Di\Collector\ClassCollector;
use Skernl\Di\Collector\MethodCollector;
use Skernl\Di\Collector\PropertyCollector;
use Skernl\Di\Exception\InvalidDefinitionException;

/**
 * @ObjectDefinition
 * @\Skernl\Di\Definition\ObjectDefinition
 */
class ObjectDefinition implements DefinitionInterface
{
    private string $className;

    private bool $instantiable;

    private array $methodParameters = [];

    /**
     * @param ReflectionClass $reflectionClass
     */
    public function __construct(private readonly ReflectionClass $reflectionClass)
    {
        $this->instantiable = $this->reflectionClass->isInstantiable();
        $this->collect();
    }

    public function getParameters(string $method)
    {
        if (!$this->reflectionClass->hasMethod($method)) {
            throw new InvalidDefinitionException(
                sprintf(
                    'Entry "%s" cannot be resolved: class %s does not have method %s',
                    $this->getClassName(),
                    $this->getClassName(),
                    $method
                )
            );
        }
        if (isset($this->methodParameters [$method])) {
            return $this->methodParameters [$method];
        }
        return $this->methodParameters [$method] = $this->reflectionClass->getMethod($method)->getParameters();
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        isset($this->className) || $this->className = $this->reflectionClass->getName();
        return $this->className;
    }

    public function isInstantiable(): bool
    {
        return $this->instantiable;
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
            AnnotationCollector::collect(
                $attribute->getName(),
                $this->getClassName(),
                $arguments
            );
            ClassCollector::collect(
                $this->getClassName(),
                $attribute->getName(),
                $arguments
            );
        }
    }

    private function collectMethod(): void
    {
        $methods = $this->reflectionClass->getMethods();
        foreach ($methods as $method) {
            $attributes = $method->getAttributes();
            foreach ($attributes as $attribute) {
                $arguments = $attribute->getArguments();
                MethodCollector::collect(
                    $this->getClassName(),
                    $method->getName(),
                    $attribute->getName(),
                    $arguments
                );
            }
        }
    }

    /**
     * @return void
     */
    private function collectProperty(): void
    {
        $properties = $this->reflectionClass->getProperties();
        foreach ($properties as $property) {
            $attributes = $property->getAttributes();
            foreach ($attributes as $attribute) {
                $arguments = $attribute->getArguments();
                PropertyCollector::collect(
                    $this->getClassName(),
                    $property->getName(),
                    $attribute->getName(),
                    $arguments
                );
            }
        }
    }
}