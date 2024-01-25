<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionException;

/**
 * @DefinitionSource
 * @\Skernl\Di\Definition\DefinitionSource
 */
class DefinitionSource implements DefinitionSourceInterface
{
    protected array $source = [];

    /**
     * @param array $classMap
     * @throws ReflectionException
     */
    public function __construct(array $classMap)
    {
        $this->normalize(
            array_keys($classMap)
        );
    }

    public function get(string $class)
    {
    }

    /**
     * @param string $class
     * @return mixed
     */
    public function getDefinition(string $class): DefinitionInterface
    {
        return $this->source [$class];
    }

    /**
     * @param array $source
     * @param object|null $definitionFactory
     * @return void
     * @throws ReflectionException
     */
    private function normalize(array $source, null|object $definitionFactory = null): void
    {
        if (is_null($definitionFactory)) {
            $definitionFactory = new DefinitionFactory();
        }
        $class = array_shift($source);
        $this->source += [
            $class => $definitionFactory->autoMode($class)
        ];
        if (!empty($source)) {
            $this->normalize($source, $definitionFactory);
        }
        unset($definitionFactory);
        $this->clean($source);
    }

    /**
     * @param array $classMap
     * @return void
     */
    private function clean(array $classMap): void
    {
        array_map(fn($class) => [$class, 'spl_autoload_unregister'], $classMap);
        unset($class);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function hasDefinition(string $id): bool
    {
        return isset($this->source [$id]);
    }
}