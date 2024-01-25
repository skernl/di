<?php
declare(strict_types=1);

namespace Skernl\Di\Resolver;

use ReflectionException;
use ReflectionParameter;
use Skernl\Contract\ContainerInterface;
use Skernl\Di\Collector\MethodCollector;
use Skernl\Di\Collector\ReflectionManager;
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
                $definition->getName()
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
     */
    private function createInstance(ObjectDefinition $objectDefinition): object
    {
        if (!$objectDefinition->isInstantiable()) {
            throw new InvalidDefinitionException(
                sprintf(
                    'Entry "%s" cannot be resolved: the class doesnt instantiable',
                    $objectDefinition->getName()
                )
            );
        }
        return new DynamicProxy($this->container, $objectDefinition);
    }
}