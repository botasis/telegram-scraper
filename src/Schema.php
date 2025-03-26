<?php

declare(strict_types=1);

namespace Botasis\Telegram\Scraper;

use Botasis\Telegram\Scraper\exceptions\MissingRequiredFieldException;

/**
 * Represents a Telegram Bot API schema
 */
final class Schema
{
    public function __construct(
        private readonly string $version,
        private readonly array $types,
        private readonly array $methods,
    ) {
        if (empty($version)) {
            throw new MissingRequiredFieldException('version');
        }
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }
}
