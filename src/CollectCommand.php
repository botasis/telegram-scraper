<?php
declare(strict_types=1);

namespace Botasis\Telegram\Scraper;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'botasis:tg-scraper:collect', 
    description: 'Collect Telegram bot API documentation and output it as json, PHP files, etc.',
)]
class CollectCommand extends Command {
    public function __construct(private readonly GeneratorCollection $generators)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $generator = $this->generators->getGenerator($input->getArgument('generator'));
        if ($generator === null) {
            $output->writeln('Generator not found: ' . $input->getArgument('generator'));

            return Command::FAILURE;
        }

        foreach ($generator->getParameters() as $parameter) {
            
        }
        

        
        return Command::SUCCESS;
    }
}