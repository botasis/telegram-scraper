<?php

declare(strict_types=1);

namespace Botasis\Telegram\Scraper\exceptions;

final class InvalidVersionException extends SchemaException
{
    protected $message = 'Invalid schema version';
}
