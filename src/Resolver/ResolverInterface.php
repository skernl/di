<?php
declare(strict_types=1);

namespace Skernl\Di\Resolver;

use Skernl\Di\Definition\DefinitionInterface;
use Skernl\Di\Exception\InvalidDefinitionException;

/**
 * @ResolverInterface
 * @\Skernl\Di\Resolver\ResolverInterface
 */
interface ResolverInterface
{
    /**
     * @param DefinitionInterface $definition
     * @param array $parameters
     * @return mixed
     * @throws InvalidDefinitionException
     */
    public function resolve(DefinitionInterface $definition, array $parameters = []): mixed;

    /**
     * @param DefinitionInterface $definition
     * @param array $parameters
     * @return bool
     */
    public function isResolvable(DefinitionInterface $definition, array $parameters = []): bool;
}