#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

$app = new \libphonenumber\buildtools\BuildApplication();
$app->run();
