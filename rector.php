<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector;
use RectorLaravel\Rector\StaticCall\EloquentMagicMethodToQueryBuilderRector;
use RectorLaravel\Set\LaravelLevelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/bootstrap/app.php',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/public',
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        privatization: true,
        earlyReturn: true,
        strictBooleans: true,
        rectorPreset: true,
    )
    ->withSkip([
        PrivatizeFinalClassMethodRector::class,
    ])
    ->withSets([
        LaravelLevelSetList::UP_TO_LARAVEL_110,
    ])->withRules([
        EloquentMagicMethodToQueryBuilderRector::class]
    )
    ->withPhpSets();
