<?php

namespace Botasis\Telegram\Scraper;

final readonly class VoidGeneratorFactory implements GeneratorFactory
{
    public function __construct(private Generator $generator) {}

    public function create(array $options): Generator
    {
        return $this->generator;
    }
}