<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use Skernl\Di\Exception\NotFoundException;

/**
 * @DefinitionSource
 * @\Skernl\Di\DefinitionSource
 */
class DefinitionSource
{
    /**
     * @var DefinitionSource|null $object
     */
    static private DefinitionSource|null $object = null;

    /**
     * @var array $map
     */
    private array $source = [];

    private function __construct()
    {
    }

    /**
     * @return object
     */
    static public function getInstance(): object
    {
        null === DefinitionSource::$object
        && DefinitionSource::$object = new DefinitionSource;

        return DefinitionSource::$object;
    }

    /**
     * @return array
     */
    public function getDefinitions(): array
    {
        return $this->source;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws NotFoundException
     */
    public function getDefinition(string $name): mixed
    {
        if (false === $this->has($name)) {
            throw new NotFoundException("No entry or class found for $name");
        }

        return $this->source [$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->source [$name]);
    }

    /**
     * @param string $name
     * @param callable|array|string $definition
     * @return void
     */
    public function setDefinition(string $name, callable|array|string $definition): void
    {
        $this->source [$name] = $definition;
    }

    /**
     * @return DefinitionSource
     */
    public function __clone()
    {
        return static::getInstance();
    }
}