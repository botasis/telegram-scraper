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
                $definition instanceof Generator => new DefaultGeneratorFactory($injector, $definition),
                $definition instanceof GeneratorFactory => $definition,
                is_subclass_of($definition, Generator::class) => new DefaultGeneratorFactory($injector, $injector->make($definition)),
                is_subclass_of($definition, GeneratorFactory::class) => $injector->make($definition),
                default => throw new \InvalidArgumentException('Invalid generator definition: ' . $definition),
            };
        }

        $this->generators = $generators;
    }

    public function getGenerator(string $name): ?GeneratorFactory {
        return $this->generators[$name] ?? null;
    }

    /**
     * Returns all available generators
     * @return array<string, GeneratorFactory> 
     */
    public function getGenerators(): array {
        return $this->generators;
    }
}