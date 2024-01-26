<?php
declare(strict_types=1);

namespace Skernl\Di\Resolver;

use Closure;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionParameter;
use Skernl\Contract\ContainerInterface;
use Skernl\Di\Definition\DefinitionInterface;
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
     * @return Closure
     * @throws ContainerExceptionInterface
     * @throws InvalidDefinitionException
     * @throws NotFoundExceptionInterface
     */
    public function resolve(DefinitionInterface $definition, array $parameters = []): Closure
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
     * @return Closure
     * @throws ContainerExceptionInterface
     * @throws InvalidDefinitionException
     * @throws NotFoundExceptionInterface
     */
    private function createInstance(ObjectDefinition $objectDefinition): Closure
    {
        if (!$objectDefinition->isInstantiable()) {
            throw new InvalidDefinitionException(
                sprintf(
                    'Entry "%s" cannot be resolved: the class doesnt instantiable',
                    $objectDefinition->getClassName()
                )
            );
        }

        $params = [];
        foreach ($objectDefinition->getConstructParameters() as $parameter) {
            $params [] = $this->getDefaultParameter($parameter);
        }

        $class = $objectDefinition->getClassName();

        $instance = new $class(... $params);

        /**
         * @var DynamicProxy|Closure $classObject
         */
        $classObject = eval(<<<EOF
            return new class () extends {$objectDefinition->getClassName()} {
                use DynamicProxy;
            };
        EOF);
        $classObject->__initialization($instance);
        /**
         * @var Closure $classObject
         */
        return $classObject;
    }

    /**
     * @param ReflectionParameter $parameter
     * @return object
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getDefaultParameter(ReflectionParameter $parameter): object
    {
        $type = $parameter->getType();
        return $this->container->get($type->getName());
    }
}