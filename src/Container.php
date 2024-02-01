<?php
declare(strict_types=1);

namespace Skernl\Di;

use Psr\Container\ContainerInterface;
use Skernl\Container\Composer;
use Skernl\Di\Contract\DependencyInjectionInterface;

/**
 * @Container
 * @\Skernl\Di\Container
 */
class Container implements DependencyInjectionInterface
{
    /**
     * @var ContainerInterface $container
     */
    private ContainerInterface $container;

    public function __construct()
    {
        $this->container = new \Skernl\Container\Container();
    }

    public function beforeAnnotation(string $class)
    {
        $annotation = Composer::getAnnotation($class);
        var_dump($annotation);
    }

    public function register(): ContainerInterface
    {
        $annotation = Composer::getAnnotation(\Skernl\Container\Container::class);
        var_dump($annotation);
//        return $this->container->get(ContainerInterface::class);
//        $this->container->get(ApplicationContextInterface::class);
        return $this->container;
    }
}