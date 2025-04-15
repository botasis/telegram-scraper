<?php
declare(strict_types=1);

namespace Botasis\Telegram\Scraper\Command;

use Botasis\Telegram\Scraper\GeneratorFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SymfonyGeneratorCommand extends Command
{
    private GeneratorFactory $generator;

    public function __construct(string $name, GeneratorFactory $generator)
    {
        parent::__construct($name);
        $this->generator = $generator;
        
        // Set command description from generator
        $this->setDescription($this->getGeneratorDescription());
    }

    protected function configure(): void
    {
        foreach ($this->generator->getParameters() as $name => $config) {
            $this->addOption(
                $name,
                $config['shortcut'] ?? null,
                $config['mode'] ?? InputOption::VALUE_NONE,
                $config['description'] ?? ''
            );
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Get the actual generator instance
        $generator = $this->generator->create($input->getOptions());
        
        // Load schema and generate
        /** 
         * FIXME load schema
         * @var Schema $schema
         **/
        $generator->generate($schema, $outputDir);

        $output->writeln(sprintf(
            'Successfully generated code using %s generator',
            $this->getName()
        ));

        return Command::SUCCESS;
    }

    private function getGeneratorDescription(): string
    {
        // Get description from generator parameters
        $parameters = $this->generator->getParameters();
        return $parameters['description'] ?? sprintf(
            'Generates code using the %s generator',
            $this->getName()
        );
    }

    private function addGeneratorParameters(): void
    {
        $parameters = $this->generator->getParameters();
        
        foreach ($parameters as $name => $config) {
            if ($config['type'] === 'argument') {
                $this->addArgument(
                    $name,
                    $config['mode'] ?? InputArgument::REQUIRED,
                    $config['description'] ?? ''
                );
            } elseif ($config['type'] === 'option') {
                $this->addOption(
                    $name,
                    $config['shortcut'] ?? null,
                    $config['mode'] ?? InputOption::VALUE_NONE,
                    $config['description'] ?? ''
                );
            }
        }
    }
}
