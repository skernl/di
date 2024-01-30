<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

use Composer\Autoload\ClassLoader;
use ReflectionClass;
use ReflectionException;
use Skernl\Di\Definition\DefinitionInterface;
use Skernl\Di\Definition\EnumDefinition;
use Skernl\Di\Definition\InterfaceDefinition;
use Skernl\Di\Definition\ObjectDefinition;
use Skernl\Di\Definition\TraitDefinition;

/**
 * @SourceManager
 * @\Skernl\Di\Definition\SourceManager
 */
class SourceManager
{
    /**
     * @var array $source
     */
    private array $source = [];

    /**
     * @var ClassLoader $classLoader
     */
    private ClassLoader $classLoader;

    /**
     * @throws ReflectionException
     */
    public function __construct()
    {
        $this->composerInit();
        $this->normalize(
            array_keys(
                $this->classLoader->getClassMap()
            )
        );
    }

    private function composerInit(): void
    {
        $loaders = ClassLoader::getRegisteredLoaders();
        /**
         * @var ClassLoader $classLoader
         */
        $this->classLoader = reset($loaders);
    }

    /**
     * @param string $class
     * @return DefinitionInterface|null
     */
    public function getSource(string $class): DefinitionInterface|null
    {
        return $this->source [$class] ?? null;
    }

    /**
     * @param string $class
     * @return bool
     */
    public function hasSource(string $class): bool
    {
        return isset($this->source [$class]);
    }

    /**
     * @param array $source
     * @return void
     * @throws ReflectionException
     */
    private function normalize(array $source = []): void
    {
        $class = array_shift($source);
        if (class_exists($class)) {
            $this->source [$class] = new ObjectDefinition(
                new ReflectionClass($class)
            );
        } elseif (enum_exists($class)) {
            $this->source [$class] = new EnumDefinition(
                new ReflectionClass($class)
            );
        } elseif (interface_exists($class)) {
            $this->source [$class] = new InterfaceDefinition(
                new ReflectionClass($class)
            );
        } elseif (trait_exists($class)) {
            $this->source [$class] = new TraitDefinition(
                new ReflectionClass($class)
            );
        }
        empty($source) || self::normalize($source);
    }
}