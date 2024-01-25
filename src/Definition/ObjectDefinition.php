<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Skernl\Di\Annotation\ClassAnnotationCollector;
use Skernl\Di\Annotation\PropertyAnnotationCollector;

/**
 * @ObjectDefinition
 * @\Skernl\Di\Definition\ObjectDefinition
 */
class ObjectDefinition extends DefinitionAbstract implements DefinitionInterface
{
    private PropertyAnnotationCollector $propertyInject;

    public function __construct(private readonly ClassAnnotationCollector $annotationCollector)
    {
    }

    public function init(string $class, ReflectionClass $reflectionClass): void
    {
        parent::init($class, $reflectionClass);
        $this->instantiable = $reflectionClass->isInstantiable();
        $this->setCollect();
    }

    protected function setCollect(): void
    {
        //  class
        $classAttributes = $this->reflectionClass->getAttributes();
        foreach ($classAttributes as $attribute) {
            $this->annotationCollector->collectClass(
                $this->class,
                $attribute->getName(),
                $attribute->getArguments()
            );
        }
        //  method
        $methods = $this->reflectionClass->getMethods();
        foreach ($methods as $method) {
            $methodAttributes = $method->getAttributes();
            foreach ($methodAttributes as $attribute) {
                $this->annotationCollector->collectMethod(
                    $this->class,
                    $method->getName(),
                    $attribute->getName(),
                    $attribute->getArguments()
                );
            }
        }
        //  property
        $properties = $this->reflectionClass->getProperties();
        $propertyAnnotationCollector = new PropertyAnnotationCollector;
        $propertyAnnotationCollector->init($properties);
        $this->propertyInject = $propertyAnnotationCollector;
//        foreach ($properties as $property) {
//            $this->propertyInject [] = [
//                $property->getName() => new PropertyAnnotationCollector()
//            ];
//            //            $propertyAttributes = $property->getAttributes();
////            foreach ($propertyAttributes as $attribute) {
////                $this->annotationCollector->collectProperty(
////                    $this->class,
////                    $property->getName(),
////                    $attribute->getName(),
////                    $attribute->getArguments()
////                );
////            }
//        }
    }

    /**
     * @return ReflectionClass
     */
    public function getReflectClass(): ReflectionClass
    {
        return $this->reflectionClass;
    }

    public function createInstance(ReflectionClass $reflectionClass, array $parameters = [])
    {
        return $reflectionClass->newInstanceArgs($parameters);
    }

//    public function createInstance($reflectionClass, array $parameters = [])
//    {
//        return $this->reflectionClass->newInstanceArgs($parameters);
//    }

    /**
     * @return array|PropertyAnnotationCollector
     */
    public function getAnnotationProperties(): PropertyAnnotationCollector
    {
        return $this->propertyInject;
//        $annotationProperties = $this->annotationCollector->getAllProperty($this->class);
//        return $annotationProperties;
//        $properties = [];
//        foreach ($annotationProperties as $property) {
//            $name = $property->getName();
//            $propertyValue = $this->reflectionClass->getProperty($name);
//            $properties += [
//                $name => $propertyValue,
//            ];
//        }
//        return $properties;
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