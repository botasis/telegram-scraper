<?php

declare(strict_types=1);

namespace Botasis\Telegram\Scraper;

interface GeneratorFactory
{
    public function create(array $options): Generator;

    public function getParameters(): array;
}

