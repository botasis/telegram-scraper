<?php

declare(strict_types=1);

namespace Botasis\Telegram\Scraper;

#[\Attribute(\Attribute::TARGET_PARAMETER)]
/**
 * Mark parameter of a Generator with this attribute to enable configuration
 * of the Generator parameter through a console command parameter when invoked.
 */
class GeneratorOption
{
    public function __construct(
        public readonly string $description,
        public readonly ?string $shortcut = null,
    ) {}
}
