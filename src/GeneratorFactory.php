<?php

declare(strict_types=1);

namespace Botasis\Telegram\Scraper;

/**
 * GeneratorFactory creates a generator instance
 * by converting input options to a generator constructor arguments
 */
interface GeneratorFactory
{
    /**
     * Create a {@see Generator} using input options
     */
    public function create(array $options): Generator;

    /**
     * Returns list of available input options
     */
    public function getParameters(): array;
}

