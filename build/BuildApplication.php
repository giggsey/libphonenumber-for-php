<?php

namespace libphonenumber\buildtools;

use libphonenumber\buildtools\Commands\BuildMetadataPHPFromXMLCommand;
use libphonenumber\buildtools\Commands\GeneratePhonePrefixDataCommand;
use libphonenumber\buildtools\Commands\GenerateTimeZonesMapDataCommand;
use Symfony\Component\Console\Application;

class BuildApplication extends Application
{
    const VERSION = '5';

    public function __construct()
    {
        parent::__construct('libphonenumber Data Builder', self::VERSION);

        $this->addCommands(
            array(
                new BuildMetadataPHPFromXMLCommand(),
                new GeneratePhonePrefixDataCommand(),
                new GenerateTimeZonesMapDataCommand(),
            )
        );
    }
}
