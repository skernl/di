<?php
declare(strict_types=1);

namespace Skernl\Di\Resolver;

use RuntimeException;
use Skernl\Contract\ContainerInterface;
use Skernl\Di\Definition\DefinitionInterface;
use Skernl\Di\Definition\ObjectDefinition;
use Skernl\Di\Exception\InvalidDefinitionException;

/**
 * @ResolverDispatcher
 * @\Skernl\Di\Scheduler\ResolverDispatcher
 */
class ResolverDispatcher
{
    /**
     * @var ObjectResolver $objectResolver
     */
    private ObjectResolver $objectResolver;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @param DefinitionInterface $definition
     * @return bool
     */
    public function isResolvable(DefinitionInterface $definition): bool
    {
        return $definition->isInstantiable();
    }

    /**
     * @param DefinitionInterface $definition
     * @param array $parameters
     * @return mixed
     * @throws InvalidDefinitionException
     */
    public function resolve(DefinitionInterface $definition, array $parameters = []): mixed
    {
        return $this->getDefinitionResolver($definition)->resolve($definition, $parameters);
    }

    /**
     * @param DefinitionInterface $definition
     * @return ResolverInterface
     */
    private function getDefinitionResolver(DefinitionInterface $definition): ResolverInterface
    {
        if ($definition instanceof ObjectDefinition) {
            return $this->objectResolver ??= new ObjectResolver($this->container, $this);
        }
        throw new RuntimeException(
            sprintf(
                'No parsing program defined for class %s definition configuration',
                get_class($definition)
            )
        );
    }
}