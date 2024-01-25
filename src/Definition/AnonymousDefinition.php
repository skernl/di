<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionClass;

/**
 * @AnonymousDefinition
 * @\Skernl\Di\Definition\AnonymousDefinition
 */
class AnonymousDefinition extends DefinitionAbstract implements DefinitionInterface
{
    public function init(string $class, ReflectionClass $reflectionClass): void
    {
        parent::init($class, $reflectionClass);
    }
}