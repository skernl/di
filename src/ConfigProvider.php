<?php
declare(strict_types=1);

namespace Skernl\Di;

use Skernl\Di\Annotation\Mount;
use Skernl\Di\Definition\DefinitionSourceInterface;
use Skernl\Di\Source\DefinitionSource;

/**
 * @Mount
 * @\Skernl\Di\Mount
 */
#[Mount]
class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            DefinitionSourceInterface::class => DefinitionSource::class,
        ];
    }
}