<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

use Composer\Autoload\ClassLoader;
use ReflectionClass;
use ReflectionException;
use Skernl\Di\Definition\DefinitionInterface;

/**
 * @SourceManager
 * @\Skernl\Di\Definition\SourceManager
 */
class SourceManager
{
    /**
     * @var array $source
     */
    static private array $source = [];

    /**
     * @throws ReflectionException
     */
    static public function init(): void
    {
        $loaders = ClassLoader::getRegisteredLoaders();
        /**
         * @var ClassLoader $classLoader
         */
        $classLoader = reset($loaders);
        $classMap = $classLoader->getClassMap();
        self::normalize(array_keys($classMap));
    }

    /**
     * @param string $class
     * @return ReflectionClass|null
     */
    static public function getSource(string $class): DefinitionInterface|null
    {
        return self::$source [$class] ?: null;
    }

    /**
     * @param string $class
     * @return bool
     */
    static public function hasSource(string $class): bool
    {
        return isset(self::$source [$class]);
    }

    /**
     * @param array $source
     * @return void
     * @throws ReflectionException
     */
    static private function normalize(array $source = []): void
    {

        $class = array_shift($source);

        if (class_exists($class) || enum_exists($class) || interface_exists($class) || trait_exists($class)) {
            self::$source [$class] = new ReflectionClass($class);
        }

//        if (class_exists($class)) {
//            self::$source [$class] = new ObjectDefinition(
//                new ReflectionClass($class),
//                $this->getContainer()
//            );
//        } elseif (enum_exists($class)) {
//            self::$source [$class] = new EnumDefinition(
//                new ReflectionClass($class)
//            );
//        } elseif (interface_exists($class)) {
//            self::$source [$class] = new InterfaceDefinition($class);
//        } elseif (trait_exists($class)) {
//            self::$source [$class] = new TraitDefinition(
//                new ReflectionClass($class)
//            );
//        }
        empty($source) || self::normalize($source);
    }
}