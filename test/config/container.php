<?php
declare(strict_types=1);

use Composer\Autoload\ClassLoader;

$getRegisteredLoaders = ClassLoader::getRegisteredLoaders();

/**
 * @var ClassLoader $classLoader
 */
$classLoader = reset($getRegisteredLoaders);

return $classLoader;