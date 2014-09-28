<?php

namespace libphonenumber\buildtools\Commands;


use libphonenumber\buildtools\BuildMetadataPHPFromXml;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BuildMetadataPHPFromXMLCommand extends Command
{
    protected function configure()
    {
        $this->setName('BuildMetadataPHPFromXML');
        $this->setDescription('Generate phone metadata data files');
        $this->setDefinition(
            array(
                new InputArgument('InputFile', InputArgument::REQUIRED, 'The input file containing phone number metadata in XML format.'),
                new InputArgument('OutputDirectory', InputArgument::REQUIRED, 'The output source directory to store phone number metadata (one file per region) and the country code to region code mapping file'),
                new InputArgument('DataPrefix', InputArgument::REQUIRED, 'The start of the filename to store the files (e.g. dataPrefix_GB.php'),
                new InputArgument('MappingClass', InputArgument::REQUIRED, 'The name of the mapping class generated'),
                new InputArgument('MappingClassLocation', InputArgument::REQUIRED, 'The directory where the mapping class is stored'),
                new InputArgument('LiteBuild', InputArgument::OPTIONAL, 'Whether to generate the lite-version of the metadata. When set to true, certain metadata will be omitted. AT this moment, example numbers information is omitted', false),
            )
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $build = new BuildMetadataPHPFromXml();
        $build->start(
            $input->getArgument('InputFile'),
            $input->getArgument('OutputDirectory'),
            $input->getArgument('DataPrefix'),
            $input->getArgument('MappingClass'),
            $input->getArgument('MappingClassLocation'),
            ($input->getArgument('LiteBuild') == 'true') ? true : false
        );
    }
}
