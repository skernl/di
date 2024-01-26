#! /usr/bin/php
<?php

//$memoryTable = new Swoole\Table(1024);
// 记录脚本开始时的内存使用情况
use Skernl\Di\ClassesManager;

$startMemory = memory_get_usage();
$startTime = microtime(true);

require dirname(__DIR__) . '/vendor/autoload.php';

$loaders = Composer\Autoload\ClassLoader::getRegisteredLoaders();
$loaders = reset($loaders);
$classMap = $loaders->getClassMap();

/** @noinspection PhpUnhandledExceptionInspection */
$manager = new ClassesManager($classMap);

//$indexController = $manager->getContainer()->get(\App\Controller\Index::class);
//var_dump((new \App\Controller\IndexController($indexController))->getDefaultValue());

// 记录脚本结束时的内存使用情况
$endMemory = memory_get_usage();
$endTime = microtime(true);
// 计算内存使用量
$memoryUsed = $endMemory - $startMemory;
$time = $endTime - $startTime;

// 输出内存使用情况
echo "Time used: " . $time . PHP_EOL;
echo "Memory used: " . $memoryUsed . PHP_EOL;
echo "Peak memory usage: " . memory_get_peak_usage() . PHP_EOL;