<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

use Composer\Autoload\ClassLoader;
use ReflectionException;
use Skernl\Di\Definition\DefinitionInterface;
use Skernl\Di\Definition\DefinitionSourceInterface;

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
     * @param SourceManager $sourceManager
     */
    public function __construct(private readonly SourceManager $sourceManager)
    {
    }

    /**
     * @param string $class
     * @param array $parameters
     * @return DefinitionInterface|null
     */
    public function getDefinition(string $class, array $parameters = []): null|DefinitionInterface
    {
        if (isset($this->source [$class])) {
            return $this->source [$class];
        }
        return $this->source [$class] = $this->sourceManager->getSource($class);
    }

    /**
     * @param string $class
     * @return bool
     */
    public function hasDefinition(string $class): bool
    {
        return isset($this->source [$class]) || $this->sourceManager->hasSource($class);
    }
}