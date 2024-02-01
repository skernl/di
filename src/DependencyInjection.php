<?php
declare(strict_types=1);

namespace Skernl\Di;

use Psr\Container\ContainerInterface;
use Skernl\Container\Composer;
use Skernl\Di\Contract\DependencyInjectionInterface;

/**
 * @DependencyInjection
 * @\Skernl\Di\DependencyInjection
 */
readonly class DependencyInjection implements DependencyInjectionInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function beforeAnnotation(string $class)
    {
        $annotation = Composer::getAnnotation($class);
        var_dump($annotation);
    }

    public function register()
    {
        $this->beforeAnnotation(\Skernl\Container\Container::class);
//        return $this->container->get(ContainerInterface::class);
    }
}