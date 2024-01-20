<?php
declare(strict_types=1);

namespace Skernl\Di\Contract;

/**
 * @ContainerSource
 * @\Skernl\Di\Contract\ContainerSource
 */
interface ContainerSource
{
    /**
     * Returns the DI definition for the entry name.
     *
     * @throws InvalidSourceException an invalid definition was found
     */
    public function getDefinition(string $name): ?DefinitionInterface;

    /**
     * @return array definitions indexed by their name
     */
    public function getDefinitions(): array;

    /**
     * @param array|callable|string $definition
     */
    public function addDefinition(string $name, $definition): static;

    public function clearDefinitions(): void;
}