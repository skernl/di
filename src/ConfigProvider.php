<?php
declare(strict_types=1);

namespace Skernl\Di;

use Skernl\Di\Annotation\Mount;

/**
 * @Mount
 * @\Skernl\Di\Mount
 */
#[Mount]
class ConfigProvider
{
    public function __invoke(): array
    {
        return [];
    }
}