<?php

namespace Botasis\Telegram\Scraper;

use Yiisoft\Injector\Injector;

final readonly class DefaultGeneratorFactory implements GeneratorFactory
{
    public function __construct(
        private Injector $injector,
        private string|Generator $generator
    ) {}

    public function create(array $options): Generator
    {
        if ($this->generator instanceof Generator) {
            return $this->generator;
        }

        return $this->injector->make($this->generator, $options);
    }

    public function getParameters(): array
    {
        return [];
    }
}