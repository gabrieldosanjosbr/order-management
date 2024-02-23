<?php

namespace App\Infrastructure\Command;

use App\Domain\Service\Order\Import as OrderImportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OrderImportCommand extends Command
{
    protected static $defaultName = 'app:order:import';
    private $orderImportService;

    public function __construct(OrderImportService $orderImportService, string $name = null)
    {
        parent::__construct($name);

        $this->orderImportService = $orderImportService;
    }

    protected function configure(): void
    {
        $this->setDescription("Import orders from resources folder located at root directory");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->orderImportService->execute();
        } catch (\Exception $e) {
            $output->writeln(sprintf(
                '<error>%s</error>',
                $e->getMessage()
            ));
            return 1;
        }

        $output->writeln(sprintf(
            '<info>%s</info>',
            'Orders were successfully imported.'
        ));

        return 0;
    }
}
