<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

/**
 * @ObjectDefinition
 * @\Skernl\Di\Definition\ObjectDefinition
 */
class ObjectDefinition extends AbstractDefinition
{
    /**
     * @var ObjectDefinition $instance
     */
    static protected ObjectDefinition $instance;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className ?? $this->name;
    }

    /**
     * @return bool
     */
    public function isClassExist(): bool
    {
        return $this->classExist;
    }

    public function isInstantiable(): bool
    {
        return $this->instantiable;
    }
}