#! /usr/bin/php
<?php

//$memoryTable = new Swoole\Table(1024);

use Skernl\Contract\ContainerInterface;

require dirname(__DIR__) . '/vendor/autoload.php';

$loaders = Composer\Autoload\ClassLoader::getRegisteredLoaders();
$loaders = reset($loaders);
$classMap = $loaders->getClassMap();

/** @noinspection PhpUnhandledExceptionInspection */
$classes = new Skernl\Di\ClassesCollectorManager($classMap);

$definitionSource = new Skernl\Di\Definition\DefinitionSource([]);

$container = new \Skernl\Di\Container($definitionSource);

$object = $container->get(ContainerInterface::class);

var_dump($object);