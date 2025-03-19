<?php

declare(strict_types=1);

namespace libphonenumber\buildtools\Commands;

use libphonenumber\buildtools\GenerateTimeZonesMapData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @internal
 */
class GenerateTimeZonesMapDataCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('GenerateTimeZonesMapData');
        $this->setDescription('Generate time zone data files');
        $this->setDefinition(
            [
                new InputArgument('InputFile', InputArgument::REQUIRED, 'The input file containing the timezone map data'),
                new InputArgument('OutputDirectory', InputArgument::REQUIRED, 'The output directory to save the file'),
                new InputArgument('OutputNamespace', InputArgument::REQUIRED, 'The output namespace'),
            ]
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        new GenerateTimeZonesMapData(
            $input->getArgument('InputFile'),
            $input->getArgument('OutputDirectory'),
            $input->getArgument('OutputNamespace'),
        );

        return self::SUCCESS;
    }
}
