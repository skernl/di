<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

/**
 * 规范化不同的类处理、极大提高处理速度
 * Standardize different class processing and greatly improve processing speed.
 * @DefinitionFactory
 * @\Skernl\Di\Definition\DefinitionFactory
 */
final class DefinitionFactory
{
    /**
     * @var SingletonDefinition $objectDefinition
     */
    static public SingletonDefinition $singletonDefinition;

    /**
     * @var ObjectDefinition $objectDefinition
     */
    static public ObjectDefinition $objectDefinition;

    public function __construct()
    {
    }

    /**
     * 约束单例模式的处理
     * @param string $name
     * @param string|null $className
     * @return SingletonDefinition
     */
    public function singletonDefinition(string $name, null|string $className = null): SingletonDefinition
    {
        isset(self::$objectDefinition) || self::$singletonDefinition = new SingletonDefinition;
        $clone = clone self::$singletonDefinition;
        $clone->init($name, $className);
        return $clone;
    }

    /**
     * 约束普通类的处理
     * @param string $name
     * @param string|null $className
     * @return ObjectDefinition
     */
    public function objectDefinition(string $name, null|string $className = null): ObjectDefinition
    {
        isset(self::$objectDefinition) || self::$objectDefinition = new ObjectDefinition;
        $clone = clone self::$objectDefinition;
        $clone->init($name, $className);
        return $clone;
    }
}