#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$app = new \libphonenumber\buildtools\BuildApplication();
$app->run();
