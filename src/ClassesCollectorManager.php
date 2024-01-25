<?php
declare(strict_types=1);

namespace Skernl\Di;

use ReflectionClass;
use ReflectionException;
use Skernl\Di\Exception\ClassNotFoundException;

/**
 * @ClassesCollectorManager
 * @\Skernl\Di\ClassesCollectorManager
 */
class ClassesCollectorManager
{
    /**
     * @var array $instance
     */
    private array $instance = [];

    /**
     * @param array $classMap
     * @throws ClassNotFoundException
     * @throws ReflectionException
     */
    public function __construct(array $classMap)
    {
        $this->loadFile($classMap);
        spl_autoload_register(fn($class) => $this->get($class));
    }

    /**
     * @param array $classMap
     * @return void
     * @throws ReflectionException
     */
    private function load(array $classMap): void
    {
        $this->instance += array_map(fn($class) => [
            $class => new ReflectionClass($class),
        ], $classMap);
        array_map(fn($class) => [$class, 'spl_autoload_unregister'], $classMap);
        unset($classMap);
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
     * @param array $filePath
     * @return void
     * @throws ReflectionException
     */
    private function loadFile(array $filePath): void
    {
        foreach ($filePath as $file) {
            include_once $file;
        }
        $this->load(array_keys($filePath));
    }

}