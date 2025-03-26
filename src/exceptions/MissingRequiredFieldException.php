<?php

declare(strict_types=1);

namespace Botasis\Telegram\Scraper\exceptions;

use Throwable;

final class MissingRequiredFieldException extends SchemaException
{
    public function __construct(string $field, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Missing required field: %s', $field), $code, $previous);
    }
}
