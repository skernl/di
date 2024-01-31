<?php
declare(strict_types=1);

namespace Skernl\Di\Resolver;

use Psr\Container\ContainerInterface;
use Skernl\Di\Definition\ObjectDefinition;

/**
 * @ParameterResolver
 * @\Skernl\Di\Resolver\ParameterResolver
 */
class ParameterResolver
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function resolveParameters(ObjectDefinition $objectDefinition)
    {
        $parameters = $objectDefinition->getMethodParameters();
    }
}