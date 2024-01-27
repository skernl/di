<?php
declare(strict_types=1);

namespace Skernl\Di\Collector;

use Swoole\Table;

/**
 * @StorageRoom
 * @\Skernl\Di\Collector\StorageRoom
 * @see Table
 */
class StorageRoom
{
    private Table $instance;

    public function __construct(int $size = 64, float $conflict_proportion = 0.2)
    {
    }

    public function __call()
    {
    }
}