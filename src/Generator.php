<?php

declare(strict_types=1);

namespace Botasis\Telegram\Scraper;

use Botasis\Telegram\Scraper\Schema;

interface Generator
{
    /**
     * Generates files based on the provided schema.
     */
    public function generate(Schema $schema): void;
}
