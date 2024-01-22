#! /usr/bin/php
<?php

//define("BASE_PATH", dirname(__DIR__));
//
//require dirname(__DIR__) . '/vendor/autoload.php';
//
//$container = new \Skernl\Di\Source\Container;


class TestPerformance
{
    public static array $storageRoom = [];

    public static function testArrayKeyExists($key)
    {
        if (array_key_exists($key, self::$storageRoom)) {
            return self::$storageRoom[$key];
        }

        return self::$storageRoom[$key] = 2;
    }

    public static function testNullCoalescingAssign($key)
    {
        if (isset(self::$storageRoom [$key])) {
            return self::$storageRoom[$key];
        }

        return self::$storageRoom[$key] = 2;
    }
}

class A
{
    public int $a = 2;
}

// 测试 array_key_exists 版本
$start = microtime(true);
for ($i = 0; $i < 1000000; $i++) {
    TestPerformance::$storageRoom = [];
    TestPerformance::testArrayKeyExists("property");
}
$end = microtime(true);
echo "Array Key Exists Test Time: " . ($end - $start) . " seconds\n";

// 重置 storageRoom


// 测试 null coalescing assign 版本
$start = microtime(true);
for ($i = 0; $i < 1000000; $i++) {
    TestPerformance::$storageRoom = [];
    TestPerformance::testNullCoalescingAssign("property");
}
$end = microtime(true);
echo "Null Coalescing Assign Test Time: " . ($end - $start) . " seconds\n";
