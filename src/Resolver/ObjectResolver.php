<?php
declare(strict_types=1);

namespace Skernl\Di\Resolver;

use Skernl\Contract\ContainerInterface;
use Skernl\Di\Collector\MethodCollector;

/**
 * @ObjectResolver
 * @\Skernl\Di\Resolver\ObjectResolver
 */
class ObjectResolver
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function resolve(string $name)
    {
        return $this->createInstance($name);
    }

    private function createInstance(string $name)
    {
        $parameters = [];
    }
}