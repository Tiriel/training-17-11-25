<?php

namespace App\Serializer\NameConverter;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class AppNameConverter implements NameConverterInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.name_converter.camel_case_to_snake_case')]
        private readonly NameConverterInterface $camelCaseToSnakeCase,
    ) {}

    /**
     * @inheritDoc
     */
    public function normalize(string $propertyName): string
    {
        return 'app_'.$this->camelCaseToSnakeCase->normalize($propertyName);
    }

    /**
     * @inheritDoc
     */
    public function denormalize(string $propertyName): string
    {
        return str_starts_with($propertyName, 'app_')
            ? $this->camelCaseToSnakeCase->denormalize(substr($propertyName, 4))
            : $propertyName;
    }
}
