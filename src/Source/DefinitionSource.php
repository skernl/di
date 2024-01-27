<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionException;
use Skernl\Di\Annotation\ClassAnnotationCollector;

/**
 * @DefinitionSource
 * @\Skernl\Di\Definition\DefinitionSource
 */
class DefinitionSource implements DefinitionSourceInterface
{
    /**
     * @var array $source
     */
    private array $source = [];

    /**
     * @var ClassAnnotationCollector $annotationCollector
     */
    private ClassAnnotationCollector $annotationCollector;

    /**
     * @param array $classMap
     * @throws ReflectionException
     */
    public function __construct()
    {
        $this->annotationCollector = new ClassAnnotationCollector();
        $this->normalize(
            array_keys($classMap)
        );
    }

    /**
     * @param string $class
     * @param array $parameters
     * @return mixed
     */
    public function getDefinition(string $class, array $parameters = []): DefinitionInterface
    {
        return $this->source [$class];
    }

    /**
     * @param string $class
     * @return bool
     */
    public function hasDefinition(string $class): bool
    {
        return isset($this->source [$class]);
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
            $definitionFactory = new DefinitionFactory($this->annotationCollector);
        }

        $class = array_shift($source);
        if (!interface_exists($class) && !trait_exists($class)) {
            $this->source += [
                $class => $definitionFactory->autoMode($class)
            ];
        }

        if (!empty($source)) {
            $this->normalize($source, $definitionFactory);
        }
    }
}