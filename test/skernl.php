#! /usr/bin/php
<?php

//$memoryTable = new Swoole\Table(1024);

use Skernl\Contract\ContainerInterface;

var_dump(microtime(true));

require dirname(__DIR__) . '/vendor/autoload.php';

$loaders = Composer\Autoload\ClassLoader::getRegisteredLoaders();
$loaders = reset($loaders);
$classMap = $loaders->getClassMap();

/** @noinspection PhpUnhandledExceptionInspection */
$manager = new Skernl\Di\ClassesManager($classMap);

$indexController = $manager->getContainer()->get(\App\Controller\IndexController::class);
//
//var_dump($indexController->index());

//var_dump((new \App\Controller\IndexController())->getDefaultValue());
//
//var_dump(class_exists(\App\Controller\IndexController::class));

var_dump(microtime(true));