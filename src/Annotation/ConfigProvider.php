<?php
declare(strict_types=1);

namespace Skernl\Di\Annotation;

use Attribute;

/**
 * @ConfigProvider
 * @\Skernl\Di\Annotation\ConfigProvider
 */
#[Attribute(Attribute::TARGET_CLASS)]
class ConfigProvider
{
    public function __construct(public $trigger = false)
    {
    }
}