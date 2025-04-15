<?php
declare(strict_types=1);

namespace Botasis\Telegram\Scraper;

use Botasis\Telegram\Scraper\Generator;
use Botasis\Telegram\Scraper\GeneratorFactory;
use Yiisoft\Injector\Injector;

final readonly class GeneratorCollection
{
    private const array DEFAULT_GENERATORS = [
        /* 'php' => \Botasis\Telegram\Scraper\Generator\PhpGenerator::class,
        'php2' => \Botasis\Telegram\Scraper\Generator\PhpGeneratorFactory::class,
        'foo' => new FooGenerator(),
        'bar' => new BarGeneratorFactory(), */
    ];

    /**
     * @var array<string, GeneratorFactory>
     */
    private readonly array $generators;

    /**
     * @param array<string, class-string<Generator>|Generator|class-string<GeneratorFactory>|GeneratorFactory> $definitions 
     */
    public function __construct(
        array $definitions,
        private ?Injector $injector = null,
    ) {
        $injector ??= new Injector();

        $generators = [];
        foreach ($definitions as $name => $definition) {
            $generators[$name] = match (true) {
                $definition instanceof Generator || is_subclass_of($definition, Generator::class) => new GeneratorDefinition(
                    new DefaultGeneratorFactory($injector, $definition),
                    [],
                ),
                $definition instanceof GeneratorFactory || is_subclass_of($definition, GeneratorFactory::class) => new GeneratorDefinition(
                    $definition,
                    [],
                ),
                default => throw new \InvalidArgumentException('Invalid generator definition: ' . $definition),
            };
        }

        $this->generators = $generators;
    }

    public function getGenerator(string $name): ?GeneratorDefinition {
        return $this->generators[$name] ?? null;
    }

    public function getGenerators(): array {
        return $this->generators;
    }
}