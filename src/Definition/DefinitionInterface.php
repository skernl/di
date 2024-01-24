<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

/**
 * @DefinitionInterface
 * @\Skernl\Di\Definition\DefinitionInterface
 */
interface DefinitionInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return bool
     */
    public function isClassExist(): bool;

    /**
     * @return bool
     */
    public function isInstantiable(): bool;
}