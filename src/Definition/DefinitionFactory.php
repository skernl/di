<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionClass;
use ReflectionException;
use Skernl\Di\Annotation\ClassAnnotationCollector;

/**
 * @DefinitionFactory
 * @\Skernl\Di\Definition\DefinitionFactory
 */
class DefinitionFactory
{
    private AbstractDefinition $abstractDefinition;
    private EnumDefinition $enumDefinition;
    private FactoryDefinition $factoryDefinition;
    private InterfaceDefinition $interfaceDefinition;
    private ObjectDefinition $objectDefinition;
    private ReadonlyDefinition $readonlyDefinition;
    private TraitDefinition $traitDefinition;

    public function __construct(ClassAnnotationCollector $annotationCollector)
    {
        $this->abstractDefinition = new AbstractDefinition();
        $this->enumDefinition = new EnumDefinition();
        $this->factoryDefinition = new FactoryDefinition();
        $this->interfaceDefinition = new InterfaceDefinition();
        $this->objectDefinition = new ObjectDefinition($annotationCollector);
        $this->readonlyDefinition = new ReadonlyDefinition();
        $this->traitDefinition = new TraitDefinition();
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return DefinitionInterface
     */
    public function autoMode(ReflectionClass $reflectionClass): DefinitionInterface
    {
        if ($reflectionClass->isAbstract()) {
            $abstractDefinition = $this->getAbstractDefinition();
            $abstractDefinition->init($reflectionClass);
            return $abstractDefinition;
        } else {
            $objectDefinition = $this->getObjectDefinition();
            $objectDefinition->init($reflectionClass);
            return $objectDefinition;
        }
    }

    /**
     * @return AbstractDefinition
     */
    private function getAbstractDefinition(): AbstractDefinition
    {
        return clone $this->abstractDefinition;
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