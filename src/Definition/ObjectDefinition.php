<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use Skernl\Di\Collector\ReflectionManager;

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

    /**
     * @return bool
     */
    public function isInstantiable(): bool
    {
        if (isset($this->isInstantiable)) return $this->isInstantiable;
        if (class_exists($this->className)) {
            return $this->isInstantiable = ReflectionManager::reflectClass($this->className)->isInstantiable();
        }
        return $this->isInstantiable = false;
    }
}