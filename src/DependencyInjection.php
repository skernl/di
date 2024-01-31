<?php
declare(strict_types=1);

namespace Skernl\Di;

use Psr\Container\ContainerInterface;
use Skernl\Di\Contract\DependencyInjectionInterface;

/**
 * @DependencyInjection
 * @\Skernl\Di\DependencyInjection
 */
class DependencyInjection implements DependencyInjectionInterface
{
    public function __construct(private ContainerInterface $container)
    {
        var_dump(class_exists(\App\Controller\IndexController::class));
    }

    public function register()
    {
        var_dump(class_exists(\App\Controller\IndexController::class));
    }
}