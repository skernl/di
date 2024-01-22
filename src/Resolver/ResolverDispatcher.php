<?php
declare(strict_types=1);

namespace Skernl\Di\Resolver;

use Skernl\Contract\ContainerInterface;

/**
 * @ResolverDispatcher
 * @\Skernl\Di\Scheduler\ResolverDispatcher
 */
class ResolverDispatcher
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function resolve(string $name)
    {
        $this->container->get();
    }
}