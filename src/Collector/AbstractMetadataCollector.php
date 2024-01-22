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
     * @var string $key
     */
    static protected string $keyName;

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    static public function get(string $key, mixed $default = null): mixed
    {
        if (!static::has($key)) {
            return $default;
        }
        return static::$storageRoom [static::$keyName] [$key];
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    static public function notNullGet(string $key, mixed $default = null): mixed
    {
        if (!static::notNullHas($key)) {
            return $default;
        }
        return static::$storageRoom [static::$keyName] [$key];
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    static public function set(string $key, string $value): void
    {
        static::$storageRoom [static::$keyName] [$key] = $value;
    }

    /**
     * @param string $key
     * @return bool
     */
    static public function has(string $key): bool
    {
        return array_key_exists($key, static::$storageRoom [static::$keyName]);
    }

    /**
     * @param string $key
     * @return bool
     */
    static public function notNullHas(string $key): bool
    {
        return isset(static::$storageRoom [static::$keyName] [$key]);
    }
}