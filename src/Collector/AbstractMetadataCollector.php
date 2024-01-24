<?php
declare(strict_types=1);

namespace Skernl\Di\Collector;

/**
 * @AbstractMetadataCollector
 * @\Skernl\Di\Collector\AbstractMetadataCollector
 */
abstract class AbstractMetadataCollector
{
    /**
     * @var array $retailer
     */
    static protected array $storageRoom = [];

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    static public function get(string $key, mixed $default = null): mixed
    {
        if (!self::has($key)) {
            return $default;
        }
        return self::$storageRoom [$key];
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    static public function notNullGet(string $key, mixed $default = null): mixed
    {
        if (!self::notNullHas($key)) {
            return $default;
        }
        return self::$storageRoom [$key];
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    static public function set(string $key, string $value): void
    {
        self::$storageRoom [$key] = $value;
    }

    /**
     * @param string $key
     * @return bool
     */
    static public function has(string $key): bool
    {
        return array_key_exists($key, self::$storageRoom);
    }

    /**
     * @param string $key
     * @return bool
     */
    static public function notNullHas(string $key): bool
    {
        return isset(self::$storageRoom [$key]);
    }
}