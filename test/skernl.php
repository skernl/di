#! /usr/bin/php
<?php

//define("BASE_PATH", dirname(__DIR__));
//
//require dirname(__DIR__) . '/vendor/autoload.php';
//
//$container = new \Skernl\Di\Source\Container;


//#[Attribute(Attribute::TARGET_ALL)]
//class A
//{
//    public function __construct(
////        public int|array|object $classes = [],
////        public int|array $classes2 = [],
//        public int $classes3 = 1,
//    )
//    {
//    }
//
//    public function action()
//    {
//
//    }
//}
//
//$reflect = new ReflectionClass(A::class);
//
//$reflectArr = $reflect->getAttributes();
//
////foreach ($reflectArr as $value) {
////    var_dump($value->getName());
////    var_dump($value->getArguments());
////    var_dump($value->getTarget());
////}
//
//$reflectM = $reflect->getMethods();
//
//var_dump($reflect->isInstantiable());
//
//$obj = $reflect->newInstanceWithoutConstructor();
//
//
//var_dump(get_class_methods($obj));


//foreach ($reflectM as $value) {
//    if ('__construct' === $value->getName()) {
//        $params = $value->getParameters();
//        foreach ($params as $param) {
//            var_dump($param->getType()->getName());
////            var_dump(array_values($param->getType()->getTypes()));
////            $types = $param->getType()->getTypes();
////            foreach ($types as $type) {
////                var_dump($type->getName());
////            }
//        }
//    }
//}


class A
{
    static public $a = [];

    static public function set($key, $value)
    {
        self::$a [$key] = $value;
    }
}


class B extends A
{
//    static public $a = [];

    static public function seta($key, $value)
    {
        self::$a [$key] = $value;
    }

    static public function setb($key, $value)
    {
        static::$a [$key] = $value;
    }

    static public function geta()
    {
        return self::$a;
    }

    static public function getb()
    {
        return static::$a;
    }
}


A::set('a', '123a');
B::seta('b', '123b');
B::setb('c', '123c');

var_dump(A::$a);
var_dump(B::geta());
var_dump(B::getb());