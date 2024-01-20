<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

/**
 * @ContainerSource
 * @\Skernl\Di\Source\ContainerSource
 */
class ContainerSource
{
    /**
     * @var array $fetchedInstance
     */
    protected array $createdInstance = [];

    public function __construct()
    {
    }

    public function get(string $id)
    {
        if (!array_key_exists($id)) {
            $this->createdInstance [$id] = $this->
        }
    }

    /**
     * 默认
     * @return void
     */
    public function default()
    {

    }

    /**
     * 自动填充
     * @param string $name
     * @return void
     */
    public function autofill(string $name,)
    {

    }
}