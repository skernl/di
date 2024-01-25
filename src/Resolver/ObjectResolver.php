<?php
declare(strict_types=1);

namespace Skernl\Di\Resolver;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionAttribute;
use ReflectionException;
use Skernl\Contract\ContainerInterface;
use Skernl\Di\Definition\DefinitionInterface;
use Skernl\Di\Definition\DefinitionSource;
use Skernl\Di\Definition\ObjectDefinition;
use Skernl\Di\Exception\InvalidDefinitionException;

/**
 * @ObjectResolver
 * @\Skernl\Di\Resolver\ObjectResolver
 */
class ObjectResolver implements ResolverInterface
{
    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * @param DefinitionInterface $definition
     * @param array $parameters
     * @return ObjectDefinition
     * @throws InvalidDefinitionException
     */
    public function resolve(DefinitionInterface $definition, array $parameters = []): mixed
    {
        if ($definition instanceof ObjectDefinition) {
            return $this->createInstance($definition);
        }
        throw new InvalidDefinitionException(
            sprintf(
                'Entry "%s" cannot be resolved: the class is not instanceof ObjectDefinition',
                $definition->getClassName()
            )
        );
    }

    /**
     * @param ObjectDefinition $definition
     * @param array $parameters
     * @return bool
     */
    public function isResolvable(DefinitionInterface $definition, array $parameters = []): bool
    {
        return $definition->isInstantiable();
    }

    /**
     * @param ObjectDefinition $objectDefinition
     * @return ObjectDefinition
     * @throws InvalidDefinitionException
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function createInstance(ObjectDefinition $objectDefinition): object
    {
        if (!$objectDefinition->isInstantiable()) {
            throw new InvalidDefinitionException(
                sprintf(
                    'Entry "%s" cannot be resolved: the class doesnt instantiable',
                    $objectDefinition->getClassName()
                )
            );
        }

        $reflectClass = $objectDefinition->getReflectClass();
        $propertyInjects = $objectDefinition->getAnnotationProperties()->getInjects();
        $reflectClassObject = $reflectClass->newInstanceWithoutConstructor();
        /**
         * @var ReflectionAttribute $property
         */
        foreach ($propertyInjects as $propertyName => $property) {
//            $attributes = $property->getArguments();
//            var_dump($propertyInject);
//            foreach ($propertyInject as $propertyName => $property) {
//                var_dump($propertyName);
//                $type = $property ['type'];
//                var_dump($property);
            $pro = $reflectClass->getProperty($propertyName);
            $pro->setAccessible(true);
            $pro->setValue(
                $reflectClassObject,
                $this->container->get($property ['type'])
            );
//            }
//            foreach ($property as $annotation => $annotationParameters) {
////                $name = $attribute->getName();
////                $propertyValue = $reflectClass->getProperty($name)->getName();
//
//            }
        }

//        $parameters = $objectDefinition->getConstructParameters();
//        $params = [];
//
//        foreach () {}
//
//        foreach ($parameters as $parameter) {
//            $params [] = $this->getDefaultParameter($parameter);
//        }
        return new DynamicProxy($objectDefinition->createInstance($reflectClass));
    }

    private function getDefaultParameter(\ReflectionParameter $parameter)
    {
        $type = $parameter->getType();
        return $this->container->get($type->getName());
    }
}