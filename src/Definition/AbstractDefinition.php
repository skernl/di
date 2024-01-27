<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionClass;

/**
 * @AbstractDefinition
 * @\Skernl\Di\Definition\AbstractDefinition
 */
class AbstractDefinition extends DefinitionAbstract implements DefinitionInterface
{
    protected string $classCategory = 'abstract';

    /**
     * @param string $class
     * @param ReflectionClass $reflectionClass
     * @return void
     */
    public function init(ReflectionClass $reflectionClass): void
    {
        parent::init($reflectionClass);
    }
}