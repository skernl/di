<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionClass;
use ReflectionException;

/**
 * @DefinitionFactory
 * @\Skernl\Di\Definition\DefinitionFactory
 */
class DefinitionFactory
{
    private AbstractDefinition $abstractDefinition;
    private AnonymousDefinition $anonymousDefinition;
    private EnumDefinition $enumDefinition;
    private FactoryDefinition $factoryDefinition;
    private InterfaceDefinition $interfaceDefinition;
    private ObjectDefinition $objectDefinition;
    private ReadonlyDefinition $readonlyDefinition;
    private TraitDefinition $traitDefinition;

    public function __construct()
    {
        $this->abstractDefinition = new AbstractDefinition();
        $this->anonymousDefinition = new AnonymousDefinition();
        $this->enumDefinition = new EnumDefinition();
        $this->factoryDefinition = new FactoryDefinition();
        $this->interfaceDefinition = new InterfaceDefinition();
        $this->objectDefinition = new ObjectDefinition();
        $this->readonlyDefinition = new ReadonlyDefinition();
        $this->traitDefinition = new TraitDefinition();
    }

    /**
     * @param string $class
     * @return DefinitionInterface
     * @throws ReflectionException
     */
    public function autoMode(string $class)
    {
        $reflectionClass = new ReflectionClass($class);
        if ($reflectionClass->isAbstract()) {
            $abstractDefinition = $this->getAbstractDefinition();
            $abstractDefinition->init($class, $reflectionClass);
            return $abstractDefinition;
        } elseif ($reflectionClass->isAnonymous()) {
            $abstractDefinition = $this->getAnonymousDefinition();
            $abstractDefinition->init($class, $reflectionClass);
            return $abstractDefinition;
        } else {
            $abstractDefinition = $this->getObjectDefinition();
            $abstractDefinition->init($class, $reflectionClass);
            return $abstractDefinition;
        }
    }

    /**
     * @return AbstractDefinition
     */
    private function getAbstractDefinition(): AbstractDefinition
    {
        return clone $this->abstractDefinition;
    }

    private function getAnonymousDefinition(): AnonymousDefinition
    {
        return clone $this->anonymousDefinition;
    }

    private function getEnumDefinition(): EnumDefinition
    {
        return clone $this->enumDefinition;
    }

    private function getFactoryDefinition(): FactoryDefinition
    {
        return clone $this->factoryDefinition;
    }

    private function getInterfaceDefinition(): InterfaceDefinition
    {
        return clone $this->interfaceDefinition;
    }

    private function getObjectDefinition(): ObjectDefinition
    {
        return clone $this->objectDefinition;
    }

    private function getReadonlyDefinition(): ReadonlyDefinition
    {
        return clone $this->readonlyDefinition;
    }

    private function getTraitDefinition(): TraitDefinition
    {
        return clone $this->traitDefinition;
    }
}