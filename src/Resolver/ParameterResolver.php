<?php
declare(strict_types=1);

namespace Skernl\Di\Resolver;

use Skernl\Di\Definition\DefinitionInterface;

/**
 * @ParameterResolver
 * @\Skernl\Di\Resolver\ParameterResolver
 */
class ParameterResolver implements ResolverInterface
{
    public function resolve(DefinitionInterface $definition, array $parameters = []): mixed
    {
    }

    /**
     * @param DefinitionInterface $definition
     * @param array $parameters
     * @return bool
     */
    public function isResolvable(DefinitionInterface $definition, array $parameters = []): bool
    {
    }
}