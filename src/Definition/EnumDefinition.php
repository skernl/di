<?php
declare(strict_types=1);

namespace Skernl\Di\Definition;

use ReflectionClass;

/**
 * @EnumDefinition
 * @\Skernl\Di\Definition\EnumDefinition
 */
class EnumDefinition
{
    public function __construct(ReflectionClass $reflectionClass)
    {
    }
}