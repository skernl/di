<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Skernl\Contract\ContainerInterface as SkernlContainerInterface;
use Skernl\Di\Exception\NotFoundException;
use Skernl\Di\Resolver\ResolverDispatcher;

/**
 * This is an interface in the di container that is allowed to be called externally.
 * @Container
 * @\Skernl\Di\Container
 */
final class Container implements SkernlContainerInterface
{
    protected array $resolvedEntries;

    public function __construct(protected ResolverDispatcher $containerSource)
    {
        $this->resolvedEntries = [
            self::class => $this,
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
     */
    public function get(string $id): mixed
    {
        if (array_key_exists($id, $this->resolvedEntries)) {
            return $this->resolvedEntries [$id];
        }

        if (!$this->has($id)) {
            throw new NotFoundException(
                sprintf(
                    "\033[31mNo entry or class found for %d\033[0m\n",
                    $id
                )
            );
        }

        return $this->resolvedEntries [$id] = $this->containerSource->get($id);
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
        if (array_key_exists($id, $this->resolvedEntries)) {
            return true;
        }

        return DefinitionSource::createInstance()->has($id);
    }
}