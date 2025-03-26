<?php
declare(strict_types=1);

namespace Botasis\Telegram\Scraper\Command;

use Botasis\Telegram\Scraper\Command\SymfonyGeneratorCommand;
use Botasis\Telegram\Scraper\GeneratorCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Exception\CommandNotFoundException;

final class SymfonyCommandLoader implements CommandLoaderInterface
{
    public function __construct(private readonly GeneratorCollection $collection) {}
    
    public function get(string $name): Command {
        $generator = $this->collection->getGenerator($name);
        if ($generator === null) {
            throw new CommandNotFoundException($name);
        }

        return new SymfonyGeneratorCommand($name, $generator);
    }

    public function has(string $name): bool {
        return $this->collection->getGenerator($name) !== null;
    }

    public function getNames(): array {
        return array_keys($this->collection->getGenerators());
    }
}
