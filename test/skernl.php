#! /usr/bin/php
<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$config = [
    Skernl\Contract\ContainerInterface::class
    => Skernl\Di\Container::class
];

$container = new Skernl\Di\Container();

foreach ($config as $key => $value) {
    Skernl\Di\Definition\DefinitionSource::getInstance()->setDefinition($key, $value);
}

var_dump($container->get(Skernl\Contract\ContainerInterface::class));