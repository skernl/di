<?php
declare(strict_types=1);

namespace Skernl\Di\Exception;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @NotFoundException
 * @\Skernl\Di\Exception\NotFoundException
 */
class NotFoundException extends Exception implements NotFoundExceptionInterface
{
}