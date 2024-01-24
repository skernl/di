#! /usr/bin/php
<?php

use Skernl\Contract\ContainerInterface;

define("BASE_PATH", dirname(__DIR__));

require dirname(__DIR__) . '/vendor/autoload.php';

$loaders = Composer\Autoload\ClassLoader::getRegisteredLoaders();
$loaders = reset($loaders);
$classes = array_values($loaders->getClassMap());

class ActionA
{
    public function indexA()
    {
        return 456;
    }
}

class IndexController
{
    public function __construct(protected ActionA $actionA)
    {
    }

    public function index()
    {
        return $this->actionA->indexA();
    }
}

$config = [
    IndexController::class => IndexController::class,
];

$definitionSource = new Skernl\Di\Definition\DefinitionSource($config);

$container = new Skernl\Di\Source\Container($definitionSource);

$object = $container->get(ContainerInterface::class)->get(IndexController::class);

var_dump($object->index());