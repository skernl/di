<?php
declare(strict_types=1);

namespace Skernl\Di\Collector;

/**
 * @SourceCollector
 * @\Skernl\Di\Collector\SourceCollector
 */
class SourceCollector extends AbstractMetadataCollector
{
    public function __construct(array $source)
    {
    }

    /**
     * @param array $source
     * @return array
     */
    protected function init(array $source)
    {
        $aggregations = [];
        foreach ($source as $identifier => $definition) {

        }
    }
}