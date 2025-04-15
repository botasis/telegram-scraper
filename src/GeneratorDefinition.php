<?php

declare(strict_types=1);

namespace Botasis\Telegram\Scraper;

final readonly class GeneratorDefinition
{
    public function __construct(
        private readonly GeneratorFactory $generator,
        private readonly array $parameters = []
    ) {
    }

    public function getParameters(): array
    {
        return $this->generator->getParameters();
    }

    public function getGenerator(array $parameters): Generator
    {
        return $this->generator->create($parameters);
    }
}
