<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__);

$config = new PhpCsFixer\Config();
return $config->setRules(
    [
        '@PER-CS2.0' => true,
        '@PHP74Migration' => true,
        'single_quote' => true,
        'no_unused_imports' => true,
        'no_superfluous_phpdoc_tags' => [
            'allow_hidden_params' => true,
            'allow_mixed' => true,
            'remove_inheritdoc' => true,
        ],
        'phpdoc_trim' => true,
    ]
)
->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
->setFinder($finder);
