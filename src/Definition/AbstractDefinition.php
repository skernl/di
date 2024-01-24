<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use InvalidArgumentException;
use Skernl\Di\Collector\ReflectionManager;

abstract class AbstractDefinition implements DefinitionInterface
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
     * @var bool $isInstantiable
     */
    protected bool $isInstantiable;

    public function __construct()
    {
    }

    /**
     * @param string $name
     * @param string|null $className
     * @return void
     */
    public function init(string $name, null|string $className = null): void
    {
        $this->name = $name;
        $this->className = $className ?? $name;
        $this->classExist = class_exists($className) || interface_exists($className);
    }

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
        return $this->className;
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
    abstract public function isInstantiable(): bool;
}