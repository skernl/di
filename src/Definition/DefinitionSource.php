<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use Skernl\Di\Collector\ReflectionManager;

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
     * @var DefinitionFactory $definitionFactory
     */
    protected DefinitionFactory $definitionFactory;

    /**
     * @param array $source
     */
    public function __construct(array $source)
    {
        $this->definitionFactory = new DefinitionFactory;
        $this->source = $this->normalizeSource($source);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasDefinition(string $name): bool
    {
        return isset($name, $this->source);
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
        $this->source[$name] ??= $this->autofill($name);

        return $this->source[$name];
    }

    /**
     * @param array $source
     * @return array
     */
    protected function normalizeSource(array $source): array
    {
        $definitions = [];
        foreach ($source as $identifier => $definition) {
            $normalizeDefinition = $this->normalizeDefinition($identifier, $definition);
            is_null($normalizeDefinition) || $definitions [$identifier] = $normalizeDefinition;
        }
        return $definitions;
    }

    /**
     * @param string $identifier
     * @param array|callable|string $definition
     * @return DefinitionInterface|null
     */
    public function normalizeDefinition(string $identifier, array|callable|string $definition): ObjectDefinition|null
    {
//        if (is_callable($identifier)) {
//        }
        if (is_string($definition) && class_exists($definition)) {
            if ($this->isSingleton($definition)) {
                return $this->autofill(
                    $identifier,
                    $this->definitionFactory->singletonDefinition($identifier, $definition)
                );
            }
            if ($this->isFactory($definition)) {
                return $this->autofill(
                    $identifier,
                    $this->definitionFactory->singletonDefinition($identifier, $definition)
                );
            }
            return $this->autofill(
                $identifier,
                $this->definitionFactory->objectDefinition($identifier, $definition)
            );
        }
        return null;
    }

    /**
     * @param string $identifier
     * @param DefinitionInterface|null $definition
     * @return DefinitionInterface|null
     */
    protected function autofill(string $identifier, null|DefinitionInterface $definition = null): null|DefinitionInterface
    {
        return $definition;
    }

    /**
     * @param string $className
     * @return bool
     */
    protected function isSingleton(string $className): bool
    {
        if (method_exists($className, '__singleton')) {
            $reflectMethod = ReflectionManager::reflectMethod($className, '__singleton');
            return !$reflectMethod->isAbstract() && $reflectMethod->isPublic();
        }
        return false;
    }

    /**
     * @param string $className
     * @return bool
     */
    protected function isFactory(string $className): bool
    {
        if (method_exists($className, '__factory')) {
            $reflectMethod = ReflectionManager::reflectMethod($className, '__factory');
            return !$reflectMethod->isAbstract() && $reflectMethod->isPublic();
        }
        return false;
    }
}