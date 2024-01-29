<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

use Composer\Autoload\ClassLoader;
use ReflectionClass;
use ReflectionException;
use Skernl\Context\ApplicationContext;
use Skernl\Contract\ContainerInterface;
use Skernl\Di\Container;
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
     * @var ContainerInterface $container
     */
    private ContainerInterface $container;

    /**
     * @param ClassLoader $classLoader
     * @throws ReflectionException
     */
    public function __construct(private ClassLoader $classLoader)
    {
        $classMap = $classLoader->getClassMap();
        $this->normalize(array_keys($classMap));
    }

    /**
     * @param string $class
     * @return ReflectionClass|null
     */
    public function getSource(string $class): DefinitionInterface|null
    {
        return $this->source [$class] ?: null;
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

        if (class_exists($class) || enum_exists($class) || interface_exists($class) || trait_exists($class)) {
            $this->source [$class] = new ReflectionClass($class);
        }

//        if (class_exists($class)) {
//            $this->source [$class] = new ObjectDefinition(
//                new ReflectionClass($class),
//                $this->getContainer()
//            );
//        } elseif (enum_exists($class)) {
//            $this->source [$class] = new EnumDefinition(
//                new ReflectionClass($class)
//            );
//        } elseif (interface_exists($class)) {
//            $this->source [$class] = new InterfaceDefinition($class);
//        } elseif (trait_exists($class)) {
//            $this->source [$class] = new TraitDefinition(
//                new ReflectionClass($class)
//            );
//        }

        empty($source) || $this->normalize($source);
    }

    /**
     * @return void
     */
    public function __invoke(): void
    {
        new ApplicationContext($this->container);
//        $definitionSource = new DefinitionSource($this);
        $this->classLoader->unregister();
        unset($this->classLoader);
//        return $definitionSource;
    }
}