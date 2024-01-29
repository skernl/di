<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

use Composer\Autoload\ClassLoader;
use Psr\Container\ContainerInterface;
use ReflectionException;
use Skernl\Di\Definition\{
    DefinitionSourceInterface,
    ObjectDefinition,
};

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
     * @var ContainerInterface $container
     */
    private ContainerInterface $container;

    private array $classMap = [];

    /**
     * @param ClassLoader $classLoader
     * @throws ReflectionException
     */
    public function __construct(ClassLoader $classLoader)
    {
        $classMap = $classLoader->getClassMap();
        $classLoader->unregister();
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
        return new Container($this->definitionSource);
    }

    /**
     * @param array $classMap
     * @return void
     * @throws ReflectionException
     */
    private function initialization(array $classMap): void
    {
        spl_autoload_register([$this, 'register']);
        foreach ($classMap as $file) {
            include_once $file;
        }
        spl_autoload_register([$this, 'register']);
        var_dump(spl_autoload_functions());
//        $this->definitionSource = new DefinitionSource($classMap);
//        $this->container = new Container($this->definitionSource);
//        $this->clean($classMap);
    }

    private function register()
    {
    }

    /**
     * @return void
     */
    private function clean(array $classMap): void
    {
        foreach (array_keys($classMap) as $function) {
            if (!interface_exists($function) && !trait_exists($function)) {
                spl_autoload_unregister($function);
            }
        }
//        array_map(fn($class) => 'spl_autoload_unregister', spl_autoload_functions());
        var_dump(class_exists(App\Controller\IndexController::class));
        spl_autoload_register([$this->definitionSource, 'getDefinition'], true, false);
    }
}