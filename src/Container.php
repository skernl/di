<?php
declare(strict_types=1);

namespace Skernl\Di;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Skernl\Contract\ContainerInterface as SkernlContainerInterface;
use Skernl\Di\Exception\InvalidDefinitionException;
use Skernl\Di\Exception\NotFoundException;
use Skernl\Di\Resolver\ResolverDispatcher;
use Skernl\Di\Source\DefinitionSource;

/**
 * @Container
 * @\Skernl\Di\Container
 */
class Container implements SkernlContainerInterface
{
    /**
     * @var array $resolvedEntries
     */
    private array $resolvedEntries;

    /**
     * @var ResolverDispatcher $resolverDispatcher
     */
    private ResolverDispatcher $resolverDispatcher;

    /**
     * @param DefinitionSource $definitionSource
     */
    public function __construct(protected DefinitionSource $definitionSource)
    {
        $this->resolverDispatcher = new resolverDispatcher($this);
        $this->resolvedEntries = [
            self::class => $this,
            PsrContainerInterface::class => $this,
            SkernlContainerInterface::class => $this,
        ];
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return mixed Entry.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws InvalidDefinitionException
     */
    public function get(string $id): mixed
    {
        if (array_key_exists($id, $this->resolvedEntries)) {
            return $this->resolvedEntries [$id];
        }

        if (!$this->has($id)) {
            throw new NotFoundException(
                sprintf(
                    "\033[31mNo entry or class found for %s\033[0m\n",
                    $id
                )
            );
        }

        $definition = $this->definitionSource->getDefinition($id);

        if (!$this->resolverDispatcher->isResolvable($definition)) {
            throw new InvalidDefinitionException(
                sprintf(
                    'Entry "%s" cannot be resolved: the class is not instantiable',
                    $definition->getClassName()
                )
            );
        }

        return $this->resolvedEntries [$id] = $this->resolverDispatcher->resolve($definition);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        if (isset($this->resolvedEntries [$id])) {
            return true;
        }

        return $this->definitionSource->hasDefinition($id);
    }
}