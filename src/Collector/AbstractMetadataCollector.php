<?php
declare(strict_types=1);

namespace Skernl\Di\Collector;

/**
 * @AbstractMetadataCollector
 * @\Skernl\Di\Collector\AbstractMetadataCollector
 */
abstract class AbstractMetadataCollector
{
    static protected array $storageRoom = [];

    static protected string $annotation = '_a';

    static protected string $class = '_c';

    static protected string $method = '_m';

    static protected string $property = '_p';
}