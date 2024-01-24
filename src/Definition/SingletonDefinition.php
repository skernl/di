<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use Skernl\Di\Collector\ReflectionManager;

/**
 * @SingletonDefinition
 * @\Skernl\Di\Definition\SingletonDefinition
 */
class SingletonDefinition extends AbstractDefinition
{
    /**
     * @var SingletonDefinition $instance
     */
    static protected SingletonDefinition $instance;

    /**
     * @return bool
     */
    public function isInstantiable(): bool
    {
        if (isset($this->isInstantiable)) return $this->isInstantiable;
        if (class_exists($this->className) && method_exists($this->className, '__singleton')) {
            $reflectMethod = ReflectionManager::reflectMethod($this->className, '__singleton');
            return $this->isInstantiable = !$reflectMethod->isAbstract() && $reflectMethod->isPublic();
        }
        return $this->isInstantiable = false;
    }
}