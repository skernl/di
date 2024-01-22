<?php
declare(strict_types=1);

namespace Skernl\Di\Collector;

/**
 * @CollectorInterface
 * @\Skernl\Di\Collector\CollectorInterface
 */
interface CollectorInterface
{
    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    static public function get(string $key, mixed $default = null): mixed;

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    static public function notNullGet(string $key, mixed $default = null): mixed;

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    static public function set(string $key, string $value): void;

    /**
     * @param string $key
     * @return bool
     */
    static public function has(string $key): bool;

    /**
     * @param string $key
     * @return bool
     */
    static public function notNullHas(string $key): bool;
}