<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

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
}