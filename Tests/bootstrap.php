<?php
ini_set('memory_limit', '1024M');
/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('libphonenumber\\Tests\\', __DIR__);
$loader->add('libphonenumber\\buildtools\\', __DIR__ . '/../build/');


/* EOF */