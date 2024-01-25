<?php
declare(strict_types=1);

namespace Skernl\Di;

use Psr\Container\{
    ContainerExceptionInterface,
    ContainerInterface,
    NotFoundExceptionInterface,
};
use ReflectionClass;
use ReflectionException;
use Skernl\Di\Definition\DefinitionSource;
use Skernl\Di\Definition\DefinitionSourceInterface;
use Skernl\Di\Definition\ObjectDefinition;
use Skernl\Di\Exception\ClassNotFoundException;

/**
 * @ClassesCollectorManager
 * @\Skernl\Di\ClassesCollectorManager
 */
class ClassesManager
{
    /**
     * @var array $instance
     */
    private array $instance = [];

    /**
     * @var DefinitionSourceInterface $definitionSource
     */
    private DefinitionSourceInterface $definitionSource;

    /**
     * @var ContainerInterface $container
     */
    protected ContainerInterface $container;

    /**
     * @param array $classMap
     * @throws ReflectionException
     */
    public function __construct(array $classMap)
    {
        $this->initialization($classMap);
    }

    /**
     * @param array $classMap
     * @return void
     * @throws ReflectionException
     */
    private function initialization(array $classMap): void
    {
        foreach ($classMap as $file) {
            include_once $file;
        }
        $this->definitionSource = new DefinitionSource($classMap);
    }

    /**
     * @param string $class
     * @return ReflectionClass
     * @throws ClassNotFoundException
     */
    public function get(string $class): ReflectionClass
    {
        if (isset($this->instance [$class])) {
            return $this->instance [$class];
        }
        throw new ClassNotFoundException(
            sprintf('Class %s does not exist', $class)
        );
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        /**
         * @var ObjectDefinition $definition
         */
        $definition = $this->definitionSource->getDefinition(Container::class);
        return $definition->createInstance([
            $this->definitionSource
        ]);
    }
}