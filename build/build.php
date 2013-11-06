#!/usr/bin/env php
<?php

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('libphonenumber\\buildtools\\', __DIR__);

$app = new \libphonenumber\buildtools\BuildApplication();
$app->run();