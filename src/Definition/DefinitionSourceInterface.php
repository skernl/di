<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

/**
 * @DefinitionSourceInterface
 * @\Skernl\Di\Definition\DefinitionSourceInterface
 */
interface DefinitionSourceInterface
{
    /**
     * @param string $class
     * @return DefinitionInterface|null
     */
    public function getDefinition(string $class): null|DefinitionInterface;

    /**
     * @param string $class
     * @return bool
     */
    public function hasDefinition(string $class): bool;
}