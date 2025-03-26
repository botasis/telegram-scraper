<?php
declare(strict_types=1);

namespace Botasis\Telegram\Scraper;

use Botasis\Telegram\Scraper\Generator;
use Botasis\Telegram\Scraper\GeneratorFactory;
use Yiisoft\Injector\Injector;

final readonly class GeneratorCollection
{
    private const array DEFAULT_GENERATORS = [
        'php' => 'Botasis\Telegram\Scraper\Generator\PhpGenerator',
        'openapi' => [
            'class' => 'Botasis\Telegram\Scraper\Generator\OpenApiGenerator',
            'factory' => 'Botasis\Telegram\Scraper\Generator\OpenApiGeneratorFactory',
        ],
        'foo' => new FooGenerator(),
        'bar' => new BarGeneratorFactory(),
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
            if ($definition instanceof Generator) {
                $generators[$name] = new GeneratorDefinition(
                    new DefaultGeneratorFactory($injector, $definition),
                    [],
                    [],
                );
            } elseif ($definition instanceof GeneratorFactory) {
                $generators[$name] = new GeneratorDefinition(
                    $definition,
                    [],
                    [],
                );
            } elseif (is_subclass_of($definition, Generator::class)) {
                $generators[$name] = new GeneratorDefinition(
                    new DefaultGeneratorFactory($injector, $definition),
                    [],
                    [],
                );
            } elseif (is_subclass_of($definition, GeneratorFactory::class)) {
                $generators[$name] = new GeneratorDefinition(
                    new DefaultGeneratorFactory($injector, $definition),
                    [],
                    [],
                );
            } else {
                throw new \InvalidArgumentException('Invalid generator definition: ' . $definition);
            }
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