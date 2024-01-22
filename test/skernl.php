#! /usr/bin/php
<?php

define("BASE_PATH", dirname(__DIR__));

//$autoload =
require dirname(__DIR__) . '/vendor/autoload.php';

//$container = new \Skernl\Di\Source\Container;
var_dump(microtime(true));
$loaders = Composer\Autoload\ClassLoader::getRegisteredLoaders();

$loaders = reset($loaders);

$classes = array_values($loaders->getClassMap());

var_dump($classes);
