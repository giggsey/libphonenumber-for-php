<?php

declare(strict_types=1);

namespace libphonenumber\buildtools;

use libphonenumber\buildtools\Commands\BuildMetadataPHPFromXMLCommand;
use libphonenumber\buildtools\Commands\GeneratePhonePrefixDataCommand;
use libphonenumber\buildtools\Commands\GenerateTimeZonesMapDataCommand;
use Symfony\Component\Console\Application;

/**
 * @internal
 */
class BuildApplication extends Application
{
    public const VERSION = '5';

    public function __construct()
    {
        parent::__construct('libphonenumber Data Builder', self::VERSION);

        $this->addCommands(
            [
                new BuildMetadataPHPFromXMLCommand(),
                new GeneratePhonePrefixDataCommand(),
                new GenerateTimeZonesMapDataCommand(),
            ]
        );
    }
}
