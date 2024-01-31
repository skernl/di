<?php
declare(strict_types=1);

namespace Skernl\Container\Contract;

use ReflectionClass;

interface CollectorInterface
{
    public function __construct(ReflectionClass $reflectionClass);

    public function getClassName(): string;

    public function isInstantiable(): bool;

    public function getProperties(): array;

    public function getMethodParameters(): array;

    public function hasMethod(string $method): bool;
}