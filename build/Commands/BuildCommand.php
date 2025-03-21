<?php

declare(strict_types=1);

namespace libphonenumber\buildtools\Commands;

use libphonenumber\buildtools\BuildMetadataPHPFromXml;
use libphonenumber\buildtools\GeneratePhonePrefixData;
use libphonenumber\buildtools\GenerateTimeZonesMapData;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

#[AsCommand(
    name: 'build',
    description: 'Build all metadata data',
)]
class BuildCommand extends Command
{
    private const GIT_REPO = 'https://github.com/google/libphonenumber.git';
    private const GIT_PATH = __DIR__ . '/../../libphonenumber-data-dir/';

    private const DIRECTORIES = [
        'carrier' => __DIR__ . '/../../src/carrier/data/',
        'test_carrier' => __DIR__ . '/../../tests/carrier/data/',
        'test_prefixmapper' => __DIR__ . '/../../tests/prefixmapper/data/',
        'core' => __DIR__ . '/../../src/data/',
        'test_core' => __DIR__ . '/../../tests/core/data/',
        'timezone' => __DIR__ . '/../../src/timezone/data/',
        'test_timezone' => __DIR__ . '/../../tests/timezone/data/',
        'geocoding' => __DIR__ . '/../../src/geocoding/data/',
    ];

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->cleanupData($output);
        $output->writeln('');

        $this->pullRepo($output);
        $output->writeln('');

        $this->compileTestData($output);
        $output->writeln('');

        $this->buildPhoneMetadata($output);
        $output->writeln('');

        $this->buildShortMetadata($output);
        $output->writeln('');

        $this->buildAlternateMetadata($output);
        $output->writeln('');

        $this->buildCarrierData($output);
        $output->writeln('');

        $this->buildTimeZonesData($output);
        $output->writeln('');

        $this->buildGeoData($output);
        $output->writeln('');

        return static::SUCCESS;
    }

    private function cleanupData(OutputInterface $output): void
    {
        $fileSystem = new Filesystem();

        $progressBar = new ProgressBar($output, count(self::DIRECTORIES));

        $output->writeln('Cleaning up directories');

        foreach (self::DIRECTORIES as $directory) {
            $progressBar->advance();
            $fileSystem->remove($directory);
            $fileSystem->mkdir($directory);
        }

        $progressBar->finish();
        $output->writeln('');
    }

    private function compileTestData(OutputInterface $output): void
    {
        $output->writeln('Compiling test metadata');

        (new BuildMetadataPHPFromXml())->start(
            $this->getGitPath('resources/PhoneNumberMetadataForTesting.xml'),
            self::DIRECTORIES['test_core'],
            'libphonenumber\\Tests\\core\\data\\PhoneNumberMetadataForTesting',
            'CountryCodeToRegionCodeMapForTesting',
            'src/',
        );

        $output->writeln('Compiling test geocoding data');

        (new GeneratePhonePrefixData())->start(
            $this->getGitPath('resources/test/geocoding/'),
            self::DIRECTORIES['test_prefixmapper'],
            'libphonenumber\\Tests\\prefixmapper\\data',
            $output,
            false,
        );

        $output->writeln('Compiling test carrier data');

        (new GeneratePhonePrefixData())->start(
            $this->getGitPath('resources/test/carrier/'),
            self::DIRECTORIES['test_carrier'],
            'libphonenumber\\Tests\\carrier\\data',
            $output,
            false,
        );

        $output->writeln('Compiling test timezone data');

        new GenerateTimeZonesMapData(
            $this->getGitPath('resources/test/timezones/map_data.txt'),
            self::DIRECTORIES['test_timezone'],
            'libphonenumber\\Tests\\timezone\\data',
        );
    }

    private function buildPhoneMetadata(OutputInterface $output): void
    {
        $output->writeln('Compiling phone metadata');

        (new BuildMetadataPHPFromXml())->start(
            $this->getGitPath('resources/PhoneNumberMetadata.xml'),
            self::DIRECTORIES['core'],
            'libphonenumber\\data\\PhoneNumberMetadata',
            'CountryCodeToRegionCodeMap',
            'src/',
        );
    }

    private function buildShortMetadata(OutputInterface $output): void
    {
        $output->writeln('Compiling short phone number metadata');

        (new BuildMetadataPHPFromXml())->start(
            $this->getGitPath('resources/ShortNumberMetadata.xml'),
            self::DIRECTORIES['core'],
            'libphonenumber\\data\\ShortNumberMetadata',
            'ShortNumbersRegionCodeSet',
            'src/',
        );
    }

    private function buildAlternateMetadata(OutputInterface $output): void
    {
        $output->writeln('Compiling alternate phone number metadata');

        (new BuildMetadataPHPFromXml())->start(
            $this->getGitPath('resources/PhoneNumberAlternateFormats.xml'),
            self::DIRECTORIES['core'],
            'libphonenumber\\data\\PhoneNumberAlternateFormats',
            'AlternateFormatsCountryCodeSet',
            'src/',
        );
    }

    private function buildCarrierData(OutputInterface $output): void
    {
        $output->writeln('Compiling carrier data');

        (new GeneratePhonePrefixData())->start(
            $this->getGitPath('resources/carrier/'),
            self::DIRECTORIES['carrier'],
            'libphonenumber\\carrier\\data',
            $output,
            false,
        );
    }


    private function buildTimeZonesData(OutputInterface $output): void
    {
        $output->writeln('Compiling time zone data');

        new GenerateTimeZonesMapData(
            $this->getGitPath('resources/timezones/map_data.txt'),
            self::DIRECTORIES['timezone'],
            'libphonenumber\\timezone\\data',
        );
    }

    private function buildGeoData(OutputInterface $output): void
    {
        $output->writeln('Compiling geocoding data');

        (new GeneratePhonePrefixData())->start(
            $this->getGitPath('resources/geocoding/'),
            self::DIRECTORIES['geocoding'],
            'libphonenumber\\geocoding\\data',
            $output,
            true,
        );
    }

    private function getGitPath(string $path): string
    {
        return self::GIT_PATH . $path;
    }

    private function pullRepo(OutputInterface $output): void
    {
        $metadataVersion = require __DIR__ . '/../../METADATA-VERSION.php';

        if (!is_dir(self::GIT_PATH)) {
            $output->writeln('Cloning libphonenumber from ' . self::GIT_REPO);
            (new Process(['git', 'clone', self::GIT_REPO, self::GIT_PATH]))->mustRun();
        } else {
            $output->writeln('Pulling libphonenumber from ' . self::GIT_REPO);
            (new Process(['git', '-C', self::GIT_PATH, 'fetch', '--all']))->mustRun();
        }

        $output->writeln('Checking out libphonenumber ' . $metadataVersion);
        (new Process(['git', '-C', self::GIT_PATH, 'checkout', $metadataVersion, '--force']))->mustRun();
    }
}
