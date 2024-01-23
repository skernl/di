<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use InvalidArgumentException;
use Skernl\Di\Collector\ReflectionManager;

abstract class AbstractDefinition
{
    /**
     * @var string $name
     */
    protected string $name;

    /**
     * @var string $className
     */
    protected string $className;

    /**
     * @var bool $classExist
     */
    protected bool $classExist;

    /**
     * @var bool $instantiable
     */
    protected bool $instantiable;

    /**
     * @param string $className
     * @return void
     */
    public function __init(string $className): void
    {
        $this->className = $className;
        $this->instantiable = class_exists($className) || interface_exists($className);
        $this->instantiable = $this->instantiable
            ?: ReflectionManager::reflectClass($this->className)->isInstantiable();
    }

    /**
     * @return object
     */
    static public function __singleton(): object
    {
        if (isset(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }
}