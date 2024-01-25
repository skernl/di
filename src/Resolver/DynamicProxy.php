<?php
declare(strict_types=1);

namespace Skernl\Di\Resolver;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use ReflectionException;
use ReflectionParameter;
use Skernl\Di\Collector\ReflectionManager;
use Skernl\Di\Definition\DefinitionInterface;
use Skernl\Di\Definition\ObjectDefinition;

/**
 * When I wrote this,only God and I understood what I was doing.
 *
 * @DynamicProxy
 * @\Skernl\Di\Collector\DynamicProxy
 */
final class DynamicProxy
{
    /**
     * @var string $className
     */
    private string $className;

    /**
     * @var object $instance
     */
    private object $instance;

    /**
     * @param ContainerInterface $container
     * @param ObjectDefinition $definition
     */
    public function __construct(ContainerInterface $container, DefinitionInterface $definition)
    {
        $this->className = $definition->getClassName();
        /**
         * @var ReflectionParameter $parameters
         */
        $parameters = $definition->getConstructParameters();
        $params = [];
        foreach ($parameters as $parameter) {
            $params [] = $this->getDefaultValue($container, $parameter);
        }
        $this->instance = $definition->createInstance($params);
    }

    private function getDefaultValue(ContainerInterface $container, ReflectionParameter $parameter)
    {
        $type = $parameter->getType();
        switch ($type) {
            case 'a1':
                return 'b1';
            case 'a2':
                return 'b2';
            default:
                $className = $type->getName();
                return $container->get($className);
        }
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        if (false === method_exists(DynamicProxy::$instance, $name)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Method %d of Class %d does not exist',
                    $name,
                    DynamicProxy::$className
                )
            );
        }

        return call_user_func_array([DynamicProxy::$instance, $name], array_values($arguments));
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    static public function __callStatic(string $name, array $arguments)
    {
        if (false === method_exists(DynamicProxy::$instance, $name)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Method %d of Class %d does not exist',
                    $name,
                    DynamicProxy::$className
                )
            );
        }

        return DynamicProxy::$instance::{$name}(... $arguments);
    }

    /**
     * @return mixed|object
     * @throws ReflectionException
     */
    public function __clone()
    {
        if (true === method_exists(DynamicProxy::$instance, '__clone')) {
            return call_user_func([DynamicProxy::$instance, '__clone']);
        }
        return clone DynamicProxy::$instance;
    }
}