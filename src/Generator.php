<?php

declare(strict_types=1);

namespace Botasis\Telegram\Scraper;

use Botasis\Telegram\Scraper\Schema;

/**
 * Generator converts Telegram schema to files of a specific format
 */
interface Generator
{
    /**
     * Generates files based on the provided schema.
     */
    public function generate(Schema $schema): void;
}
