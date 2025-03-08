<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__);

$config = new PhpCsFixer\Config();
return $config->setRules(
    [
        '@PER-CS2.0' => true,
        '@PHP81Migration' => true,
        'single_quote' => true,
        'no_unused_imports' => true,
        'no_superfluous_phpdoc_tags' => [
            'allow_hidden_params' => true,
            'allow_mixed' => true,
            'remove_inheritdoc' => true,
        ],
        'phpdoc_trim' => true,
        'declare_strict_types' => true,
        'php_unit_attributes' => true,
        '@PHPUnit100Migration:risky' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'no_empty_phpdoc' => true,
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_types' => true,
    ]
)
    ->setRiskyAllowed(true)
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setFinder($finder);
