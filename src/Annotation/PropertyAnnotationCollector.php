<?php
declare(strict_types=1);

namespace Skernl\Di\Annotation;

use ReflectionProperty;

/**
 * @ClassAnnotationCollector
 * @\Skernl\Di\Annotation\ClassAnnotationCollector
 */
class PropertyAnnotationCollector
{
    private ReflectionProperty $reflectionAttribute;
    private array $inject = [];

    public function init(array $properties): void
    {
        /**
         * @var ReflectionProperty $property
         */
        foreach ($properties as $property) {
            $type = $property->getType();
            $name = $type?->getName();
            $this->inject += [
                $property->getName() => [
                    'type' => $name,
                    'inject' => $this->setInject($property),
                ],
            ];
        }
    }

    public function setInject($property): array
    {
        $propertyInjects = [];
        $attributes = $property->getAttributes();
        foreach ($attributes as $attribute) {
            $propertyInjects += [
                $attribute->getName() => $attribute->getArguments(),
            ];
        }
        return $propertyInjects;
    }

//    public function getPropertyName(): string
//    {
//        return $this->propertyName;
//    }

    public function getInjects(): array
    {
        return $this->inject;
    }
}