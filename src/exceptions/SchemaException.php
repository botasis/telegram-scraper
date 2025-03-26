<?php

declare(strict_types=1);

namespace Botasis\Telegram\Scraper\exceptions;

abstract class SchemaException extends \RuntimeException
{
    protected $message = 'Schema exception occurred';
}