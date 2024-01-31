<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

use Skernl\Di\Definition\DefinitionInterface;
use Skernl\Di\Definition\DefinitionSourceInterface;

/**
 * @DefinitionSource
 * @\Skernl\Di\Definition\DefinitionSource
 */
class DefinitionSource extends ClassesManager implements DefinitionSourceInterface
{
    private array $bond = [];

    public function __construct()
    {
    }

    public function patch(string $name, $entry): void
    {
        $this->bond [$name] = $entry;
    }

    /**
     * @param string $class
     * @param array $parameters
     * @return DefinitionInterface|null
     */
    public function getDefinition(string $class, array $parameters = []): null|DefinitionInterface
    {
        $definition = $this->bond [$class] ?? self::$storageRoom [$class];
        if (is_string($definition)) {
            return $this->getDefinition($definition);
        }
        return $this->bond [$class] = $definition;
    }

    /**
     * @param string $class
     * @return bool
     */
    public function hasDefinition(string $class): bool
    {
        return isset($this->bond [$class]) || !is_null($this->getDefinition($class));
    }
}