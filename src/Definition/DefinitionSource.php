<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

/**
 * @DefinitionSource
 * @\Skernl\Di\Source\DefinitionSource
 */
class DefinitionSource
{
    /**
     * @var array $source
     */
    protected array $source;

    /**
     * @param DefinitionFactory $definitionFactory
     * @param array $source
     */
    public function __construct(protected DefinitionFactory $definitionFactory, array $source)
    {
        $this->source = $this->normalizeSource($source);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasDefinition(string $name): bool
    {
        return array_key_exists($name, $this->source);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getDefinition(string $name): mixed
    {
        if (isset($name, $this->source)) {
            return $this->source[$name];
        }
        return null;
    }

    /**
     * @param array $source
     * @return array
     */
    protected function normalizeSource(array $source): array
    {
        $definitions = [];
        foreach ($source as $identifier => $definition) {
            $definitions [$identifier] = $this->normalizeDefinition($definition);
        }
        return $definitions;
    }

    /**
     * @param array|callable|string $definition
     * @return ObjectDefinition|null
     */
    public function normalizeDefinition(array|callable|string $definition): null|ObjectDefinition
    {
        if (is_string($definition) && class_exists($definition)) {
            return $this->autofill($this->definitionFactory->objectDefinition($definition));
        }
        return null;
    }

    /**
     * @param ObjectDefinition $definition
     * @return ObjectDefinition
     */
    protected function autofill(ObjectDefinition $definition): ObjectDefinition
    {
        return $definition;
    }
}