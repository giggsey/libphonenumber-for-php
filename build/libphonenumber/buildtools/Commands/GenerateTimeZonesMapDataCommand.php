<?php

namespace libphonenumber\buildtools\Commands;


use libphonenumber\buildtools\GenerateTimeZonesMapData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateTimeZonesMapDataCommand extends Command
{
    protected function configure()
    {
        $this->setName('GenerateTimeZonesMapData');
        $this->setDescription('Generate time zone data files');
        $this->setDefinition(
            array(
                new InputArgument('InputFile', InputArgument::REQUIRED, 'The input file containing the timezone map data'),
                new InputArgument('OutputDirectory', InputArgument::REQUIRED, 'The output directory to save the file'),
            )
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        new GenerateTimeZonesMapData($input->getArgument('InputFile'), $input->getArgument('OutputDirectory'));
    }
}
