#! /usr/bin/php
<?php

//$memoryTable = new Swoole\Table(1024);
//
//class A
//{
//    public function get()
//    {
//        return 1;
//    }
//}
//
//$reflectClass = new ReflectionClass(A::class);
//
//spl_autoload_register();
//
//$memoryTable->set();


//use Skernl\Contract\ContainerInterface;
//
//define("BASE_PATH", dirname(__DIR__));
//
//require dirname(__DIR__) . '/vendor/autoload.php';
//
//$loaders = Composer\Autoload\ClassLoader::getRegisteredLoaders();
//$loaders = reset($loaders);
//$classes = array_values($loaders->getClassMap());
//
//class ActionA
//{
//    public function indexA()
//    {
//        return 456;
//    }
//}
//
//class IndexController
//{
//    public function __construct(protected ActionA $actionA)
//    {
//    }
//
//    public function index()
//    {
//        return $this->actionA->indexA();
//    }
//}
//
//$config = [
//    IndexController::class => IndexController::class,
//];
//
//$definitionSource = new Skernl\Di\Definition\DefinitionSource($config);
//
//$container = new Skernl\Di\Source\Container($definitionSource);
//
//$object = $container->get(ContainerInterface::class)->get(IndexController::class);
//
//var_dump($object->index());

use Skernl\Contract\ContainerInterface;

var_dump(microtime(true));

require dirname(__DIR__) . '/vendor/autoload.php';

$loaders = Composer\Autoload\ClassLoader::getRegisteredLoaders();
$loaders = reset($loaders);
$classMap = array_values($loaders->getClassMap());

class ReflectionManager
{
    static public array $container = [];

    static public function set(string $key): void
    {
        self::$container [$key] = new ReflectionClass($key);
    }

    static public function has(string $key)
    {
        return isset(self::$container [$key]);
    }

    static public function get($key): mixed
    {
        var_dump(785471);
        return self::$container [$key] ?? null;
    }

    static public function getAll()
    {
        return self::$container;
    }
}

//$reflectionClass = new ReflectionManager();

spl_autoload_register(function ($class) use ($classMap) {
    if (!isset($config [$class])) {
        throw new Exception("$class doesnt exist!");
    }
    include $config [$class];
    ReflectionManager::set($class);
});

foreach (spl_autoload_functions() as $function) {
    spl_autoload_unregister($function);
}

var_dump(ReflectionManager::getAll());


spl_autoload_register(function ($class) {
    return ReflectionManager::get($class);
});


$definitionSource = new Skernl\Di\Definition\DefinitionSource([]);

$container = new Skernl\Di\Source\Container($definitionSource);

$object = $container->get(ContainerInterface::class);

var_dump($object);