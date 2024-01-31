<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

use Composer\Autoload\ClassLoader;
use ReflectionAttribute;
use ReflectionClass;
use Skernl\Di\Collector\ClassCollector;
use Skernl\Di\Definition\ObjectDefinition;

/**
 * @ClassesCollectorManager
 * @\Skernl\Di\ClassesCollectorManager
 */
class ClassesManager
{
    static private ClassLoader $classLoader;

    static protected array $storageRoom = [];

    static protected array $annotation = [];

    static public function init(): void
    {
        self::loadClassMap();
        self::mountClassMap(
            array_keys(
                self::$classLoader->getClassMap()
            )
        );
    }

    static private function loadClassMap(): void
    {
        $loaders = ClassLoader::getRegisteredLoaders();
        /**
         * @var ClassLoader $classLoader
         */
        self::$classLoader = reset($loaders);
        self::mountClassMap(
            array_keys(
                self::$classLoader->getClassMap()
            )
        );
    }

    /**
     * @param array $classMap
     * @return void
     */
    static private function mountClassMap(array $classMap): void
    {
        $class = array_shift($classMap);
        if (class_exists($class)) {
            $collector = new ObjectDefinition(
                new ReflectionClass($class)
            );
            self::$storageRoom [$class] = $collector;
            empty($classAnnotations = $collector->getClassAnnotations())
            || self::mountClassAnnotations($class, $classAnnotations);
        }
        empty($classMap) || self::mountClassMap($classMap);
    }

    static private function mountClassAnnotations(string $class, array $classAnnotations): void
    {
        /**
         * @var ReflectionAttribute $annotation
         */
        foreach ($classAnnotations as $annotation) {
            self::$annotation [$annotation->getName()] [$class] = $annotation->getArguments();
        }
    }
}