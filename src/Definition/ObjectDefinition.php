<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionAttribute;
use ReflectionClass;
use Skernl\Contract\ContainerInterface;
use Skernl\Di\Collector\ClassCollector;
use Skernl\Di\Collector\MethodCollector;
use Skernl\Di\Collector\PropertyCollector;

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
     * @param ContainerInterface $container
     */
    public function __construct(private readonly ReflectionClass $reflectionClass, ContainerInterface $container)
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