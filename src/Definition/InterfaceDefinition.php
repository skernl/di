<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionClass;
use ReflectionException;
use Skernl\Contract\ContainerInterface;

/**
 * @InterfaceDefinition
 * @\Skernl\Di\Definition\InterfaceDefinition
 */
class InterfaceDefinition implements DefinitionInterface
{
    /**
     * @var ReflectionClass $reflectionClass
     */
    private readonly ReflectionClass $reflectionClass;

    /**
     * @var bool $instantiable
     */
    private bool $instantiable = false;

    /**
     * @param string $class
     * @throws ReflectionException
     */
    public function __construct(string $class)
    {
        $this->reflectionClass = new ReflectionClass($class);
    }

    public function isInstantiable()
    {
        $instantiable = $this->reflectionClass->isInstantiable();

        if (false === $instantiable) {

        }


    }
}