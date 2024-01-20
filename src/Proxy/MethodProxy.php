<?php
declare(strict_types=1);

namespace Skernl\Di\Proxy;

/**
 * @MethodProxy
 * @\Skernl\Di\Aspect\MethodProxy
 */
class MethodProxy
{
    /**
     * @param object $object
     * @param array $arguments
     */
    public function __construct(protected object $object, array $arguments)
    {
    }

    public function __call(string $name, array $arguments)
    {

    }
}