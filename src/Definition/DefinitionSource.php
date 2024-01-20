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

    /**
     * @param array $dependencies
     */
    private function __construct(array $dependencies)
    {
        foreach ($dependencies as $identifier => $definition) {
            if (is_string($definition) && class_exists($definition)) {
                $this->source [$identifier] = $definition;
            }
        }
    }

    /**
     * @param array $dependencies
     * @return object
     */
    static public function createInstance(array $dependencies = []): object
    {
        null === DefinitionSource::$object
        && DefinitionSource::$object = new DefinitionSource($dependencies);

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
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function getDefinition(string $name): mixed
    {
        if (false === $this->has($name)) {
            throw new NotFoundException("No entry or class found for $name");
        }

        return $this->make($name);

//        return $this->source [$name] ??= $this->make($name);
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
     * @param string $name
     * @return $name $name
     */
    public function make(string $name)
    {
        $className = $this->source [$name];

//        return new DynamicProxy($className);

        return new $className ();
    }

    /**
     * @return DefinitionSource
     */
    public function __clone()
    {
        return static::createInstance();
    }
}