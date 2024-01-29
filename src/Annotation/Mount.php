<?php
declare(strict_types=1);

namespace Skernl\Di\Annotation;

use Attribute;

/**
 * @Mount
 * @\Skernl\Di\Annotation\Mount
 */
#[Attribute(Attribute::TARGET_CLASS)]
class Mount
{
    public function __construct()
    {
    }
}