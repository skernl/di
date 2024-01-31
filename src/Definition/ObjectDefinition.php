<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Skernl\Di\Exception\InvalidDefinitionException;

/**
 * @ObjectDefinition
 * @\Skernl\Di\Definition\ObjectDefinition
 */
class ObjectDefinition implements DefinitionInterface
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

//    public function getProperties(): array
//    {
//        // TODO: Implement getProperties() method.
//    }
//
    /**
     * @param string $method
     * @return ReflectionParameter[]
     * @throws InvalidDefinitionException
     */
    public function getMethodParameters(string $method): array
    {
        try {
            return $this->reflectionClass->getMethod($method)->getParameters();
        } catch (ReflectionException) {
            throw new InvalidDefinitionException(
                sprintf(
                    'Method %s does not exist in Class %s',
                    '__construct',
                    $this->getClassName(),
                )
            );
        }
    }

    /**
     * @param string $method
     * @return array
     * @throws InvalidDefinitionException
     */
    public function getMethodDefaultParameters(string $method): array
    {
        $params = [];
        foreach ($this->getMethodParameters($method) as $parameter) {
            if ($parameter->isDefaultValueAvailable()) {
                $params [$parameter->getName()] = $parameter->getDefaultValue();
            }
        }

        return $params;
    }

    public function hasMethod(string $method): bool
    {
        return $this->reflectionClass->hasMethod($method);
    }
}