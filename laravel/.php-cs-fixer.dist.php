<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

// 1. Defina quais pastas o Fixer deve analisar
$finder = (new Finder())
    ->in([__DIR__])
    ->exclude(['vendor', 'storage', 'bootstrap/cache']) // Pastas comuns para ignorar no Laravel
    ->notPath('*.blade.php') // Evita tentar formatar arquivos Blade
    // ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

// 2. Retorne a configuração com as regras
return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        '@PhpCsFixer' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'concat_space' => ['spacing' => 'one'],
        'single_quote' => true,
        'declare_strict_types' => true,
        'visibility_required' => [
            'elements' => ['property', 'method', 'const']
        ],
        'blank_line_before_statement' => [
            'statements' => ['return', 'throw', 'try']
        ],
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true,
            'remove_inheritdoc' => true,
        ],
    ])
    ->setFinder($finder);