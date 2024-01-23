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
        isset(self::$singletonDefinition)
        || self::$singletonDefinition = SingletonDefinition::__singleton();
        isset(self::$objectDefinition)
        || self::$objectDefinition = ObjectDefinition::__singleton();
    }

    /**
     * 约束单例模式的处理
     * @param string $name
     * @return SingletonDefinition
     */
    public function singletonDefinition(string $name): SingletonDefinition
    {
        $clone = clone self::$singletonDefinition;
        $clone->__init($name);
        return $clone;
    }

    /**
     * 约束普通类的处理
     * @param string $name
     * @return ObjectDefinition
     */
    public function objectDefinition(string $name): ObjectDefinition
    {
        $clone = clone self::$objectDefinition;
        $clone->__init($name);
        return $clone;
    }
}