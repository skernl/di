#! /usr/bin/php
<?php

require dirname(__DIR__) . '/vendor/autoload.php';

var_dump();

//interface RequestInterface
//{
//    public function get();
//}
//
//class Request
//{
//    public function get()
//    {
//        return 12;
//    }
//}
//
//$config = [
//    RequestInterface::class => Request::class,
//];
//
//$container = new Skernl\Di\Source\Container();
//
//Skernl\Di\Definition\DefinitionSource::createInstance($config);
//
//$container = $container->get(\Skernl\Di\Source\Container::class);
//
/////**
//// * @var RequestInterface $request
//// */
//$request = $container->get(RequestInterface::class);
//
////echo sprintf('Class %d not exist', '123');
////
////echo "\033[31m世界，你好\033[0m";
//
//var_dump(get_class($request));
//
//var_dump($request);

//class Proxy
//{
//    public function __construct()
//    {
//
//    }
//    public function beforeMethodCall($methodName, $arguments)
//    {
//    }
//}
//
//class A
//{
//    public int $a = 123;
//
//    public string $b = "你好";
//
//    public function get()
//    {
//    }
//}
//
//
//$reflectionClass = new ReflectionClass(A::class);
//
//$methods = $reflectionClass->getMethods();
//
//foreach ($methods as $method) {
//    $methodName = $method->getName();
//
//    // 创建方法代理
//    $this->$methodName = function (...$args) use ($methodName, $method) {
//        // 在方法调用前执行监控逻辑
//        $this->methodMonitor->beforeMethodCall($methodName, $args);
//
//        // 调用实际方法
//        return $method->invokeArgs($this, $args);
//    };
//}
//
//
//$a = $reflectionClass->newInstance();
//
//var_dump($a->a);

//class Jwe
//{
//    public null|string $key = null;
//
//    public function __construct()
//    {
//
//    }
//
//    public function get()
//    {
//        return $this->key;
//    }
//}
//
