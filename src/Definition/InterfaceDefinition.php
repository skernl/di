<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionClass;
use ReflectionException;

/**
 * @InterfaceDefinition
 * @\Skernl\Di\Definition\InterfaceDefinition
 */
class InterfaceDefinition implements DefinitionInterface
{
    /**
     * @var bool $instantiable
     */
    private bool $instantiable = false;

    /**
     * @param ReflectionClass $reflectionClass
     */
    public function __construct(private readonly ReflectionClass $reflectionClass)
    {
    }

    public function isInstantiable()
    {
        $instantiable = $this->reflectionClass->isInstantiable();

        if (false === $instantiable) {

        }


    }
}