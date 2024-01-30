<?php
declare(strict_types=1);

namespace Skernl\Di\Source;

use Skernl\Di\Annotation\Mount;
use Skernl\Di\Collector\MetadataCollector;
use Skernl\Di\Definition\DefinitionSourceInterface;

/**
 * @ContainerCompensator
 * @\Skernl\Di\Source\ContainerCompensator
 */
readonly class ContainerCompensator
{
    public function __construct(private DefinitionSourceInterface $definitionSource)
    {
        $this->mount();
    }

    public function mount(): void
    {
        $mountAnnotation = MetadataCollector::getAnnotations(Mount::class);
        foreach (array_keys($mountAnnotation) as $class) {
            foreach ((new $class)() as $key => $value) {
                $this->definitionSource->patch($key, $value);
            }
        }
    }
}