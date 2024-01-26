<?php
declare(strict_types=1);

namespace Skernl\Di;

use Psr\Container\{ContainerInterface,};
use ReflectionException;
use Skernl\Di\Definition\DefinitionSource;
use Skernl\Di\Definition\DefinitionSourceInterface;
use Skernl\Di\Definition\ObjectDefinition;

/**
 * @ClassesCollectorManager
 * @\Skernl\Di\ClassesCollectorManager
 */
class ClassesManager
{
    /**
     * @var DefinitionSourceInterface $definitionSource
     */
    private DefinitionSourceInterface $definitionSource;

    /**
     * @param array $classMap
     * @throws ReflectionException
     */
    public function __construct(array $classMap)
    {
        $this->initialization($classMap);
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
        $this->clean($classMap);
    }

    /**
     * @param array $classMap
     * @return void
     */
    private function clean(array $classMap): void
    {
        array_map(fn($class) => [$class, 'spl_autoload_unregister'], $classMap);
        spl_autoload_register([$this->getContainer(), 'get']);
    }
}