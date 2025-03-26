<?php

declare(strict_types=1);

namespace Botasis\Telegram\Scraper\exceptions;

final class InvalidSchemaException extends SchemaException
{
    protected $message = 'Invalid schema provided';
}
