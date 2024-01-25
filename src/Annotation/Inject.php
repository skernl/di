<?php
declare(strict_types=1);

namespace Skernl\Di\Annotation;

use Attribute;

/**
 * @Inject
 * @\Skernl\Di\Annotation\Inject
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Inject
{
    public function __construct(
        public null|string $value = null,
        public bool        $require = true,
        public bool        $lazy = false,
    )
    {
    }
}