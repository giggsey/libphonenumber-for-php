<?php

namespace libphonenumber\buildtools\Commands;

use libphonenumber\buildtools\GeneratePhonePrefixData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GeneratePhonePrefixDataCommand extends Command
{
    protected function configure()
    {
        $this->setName('GeneratePhonePrefixData');
        $this->setDescription('Generate phone prefix data files');
        $this->setDefinition(
            [
                new InputArgument('InputDirectory', InputArgument::REQUIRED, 'The input directory containing the locale/region.txt files'),
                new InputArgument('OutputDirectory', InputArgument::REQUIRED, 'The output source directory'),
                new InputOption('expandCountries', null, InputOption::VALUE_NONE, 'Should we expand certain countries into separate files'),
            ]
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generatePhonePrefixData = new GeneratePhonePrefixData();
        $generatePhonePrefixData->start(
            $input->getArgument('InputDirectory'),
            $input->getArgument('OutputDirectory'),
            $output,
            $input->getOption('expandCountries')
        );

        return 0;
    }
}
