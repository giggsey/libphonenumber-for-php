<?php

declare(strict_types=1);

namespace libphonenumber\buildtools\Commands;

use libphonenumber\buildtools\GeneratePhonePrefixData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @internal
 */
class GeneratePhonePrefixDataCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('GeneratePhonePrefixData');
        $this->setDescription('Generate phone prefix data files');
        $this->setDefinition(
            [
                new InputArgument('InputDirectory', InputArgument::REQUIRED, 'The input directory containing the locale/region.txt files'),
                new InputArgument('OutputDirectory', InputArgument::REQUIRED, 'The output source directory'),
                new InputArgument('OutputNamespace', InputArgument::REQUIRED, 'The output namespace'),
                new InputOption('expandCountries', null, InputOption::VALUE_NONE, 'Should we expand certain countries into separate files'),
            ]
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $generatePhonePrefixData = new GeneratePhonePrefixData();
        $generatePhonePrefixData->start(
            $input->getArgument('InputDirectory'),
            $input->getArgument('OutputDirectory'),
            $input->getArgument('OutputNamespace'),
            $output,
            $input->getOption('expandCountries')
        );

        return self::SUCCESS;
    }
}
