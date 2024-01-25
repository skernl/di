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
     * @return DefinitionInterface
     */
    public function getDefinition(string $class): DefinitionInterface;
}