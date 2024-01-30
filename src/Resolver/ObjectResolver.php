<?php
declare(strict_types=1);

namespace Skernl\Di\Resolver;

use App\Controller\IndexController;
use Closure;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionParameter;
use Skernl\Contract\ContainerInterface;
use Skernl\Di\Definition\DefinitionInterface;
use Skernl\Di\Definition\ObjectDefinition;
use Skernl\Di\Exception\InvalidDefinitionException;
use Skernl\Di\Source\DynamicProxy;

/**
 * @ObjectResolver
 * @\Skernl\Di\Resolver\ObjectResolver
 */
class ObjectResolver implements ResolverInterface
{
    private ParameterResolver $parameterResolver;

    public function __construct(private ContainerInterface $container)
    {
        $this->parameterResolver = new ParameterResolver();
    }

    /**
     * @param DefinitionInterface $definition
     * @param array $parameters
     * @return Closure
     * @throws ContainerExceptionInterface
     * @throws InvalidDefinitionException
     * @throws NotFoundExceptionInterface
     */
    public function resolve(DefinitionInterface $definition, array $parameters = []): object
    {
        if ($definition instanceof ObjectDefinition) {
            return $this->createInstance($definition);
        }
        throw new InvalidDefinitionException(
            sprintf(
                'Entry "%s" cannot be resolved: the class is not instanceof ObjectDefinition',
                $definition->getClassName()
            )
        );
    }

    /**
     * @param ObjectDefinition $definition
     * @param array $parameters
     * @return bool
     */
    public function isResolvable(DefinitionInterface $definition, array $parameters = []): bool
    {
        return $definition->isInstantiable();
    }

    /**
     * @param ObjectDefinition $objectDefinition
     * @return object
     * @throws ContainerExceptionInterface
     * @throws InvalidDefinitionException
     * @throws NotFoundExceptionInterface
     */
    private function createInstance(ObjectDefinition $objectDefinition): object
    {
        if (!$objectDefinition->isInstantiable()) {
            throw new InvalidDefinitionException(
                sprintf(
                    'Entry "%s" cannot be resolved: the class doesnt instantiable',
                    $objectDefinition->getClassName()
                )
            );
        }
        $params = [];
        foreach ($objectDefinition->getParameters('__construct') as $parameter) {
            $params [] = $this->getDefaultParameter($parameter);
        }
        $class = $objectDefinition->getClassName();
        $instance = new $class(... $params);
        /**
         * @use $instance
         * @var DynamicProxy|Closure $classObject
         */
        $classObject = eval(<<<EOF
            return new class (\$instance) extends {$objectDefinition->getClassName()} {
                use Skernl\Di\Source\DynamicProxy;
            };
        EOF);
        /**
         * @var Closure $classObject
         */
        return $classObject;
    }

    /**
     * @param ReflectionParameter $parameter
     * @return object
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getDefaultParameter(ReflectionParameter $parameter): object
    {
        $type = $parameter->getType();
        return $this->container->get($type->getName());
    }
}