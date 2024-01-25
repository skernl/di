<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionClass;
use ReflectionParameter;

/**
 * @ObjectDefinition
 * @\Skernl\Di\Definition\ObjectDefinition
 */
class ObjectDefinition extends DefinitionAbstract implements DefinitionInterface
{
    public function init(string $class, ReflectionClass $reflectionClass): void
    {
        parent::init($class, $reflectionClass);
        $this->instantiable = $reflectionClass->isInstantiable();

    }

    public function createInstance(array $parameters = [])
    {
        return $this->reflectionClass->newInstanceArgs($parameters);
    }

    /**
     * @return ReflectionParameter[]
     */
    public function getConstructParameters(): array
    {
        $construct = $this->reflectionClass->getConstructor();
        if (is_null($construct)) {
            return [];
        }
        return $construct->getParameters();
    }
}