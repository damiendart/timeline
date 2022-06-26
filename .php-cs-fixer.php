<?php

/*
 * Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

$header = <<<'HEADER'
Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
This file is distributed under the MIT licence. For more information,
please refer to the accompanying "LICENCE" file.
HEADER;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PhpCsFixer' => true,
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'declare_strict_types' => true,
        'header_comment' => [
            'header' => $header,
            'location' => 'after_open',
            'separate' => 'both',
        ],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line'
        ],
        'phpdoc_line_span' => true,
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters'],
        ],
        'void_return' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->notPath('bootstrap/cache')
            ->notPath('node_modules')
            ->notPath('storage')
            ->notPath('vendor')
            ->in(__DIR__)
            ->name('*.php')
            ->name('cron-*')
            ->name('artisan')
    );
