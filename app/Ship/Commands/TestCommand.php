<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Ship\Commands;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Commands\ConsoleCommand;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class TestCommand extends ConsoleCommand
{
    protected const ALL = 'all';
    protected const OPTION_RUN_PHPUNIT = 'phpunit';
    protected const OPTION_RUN_PHPMD = 'phpmd';
    protected const OPTION_RUN_PHPCS = 'phpcs';

    protected $signature = 'developer:test';
    protected int $phpUnitTotalTests = ZERO;
    protected int $phpUnitTotalAssertions = ZERO;

    public function __construct()
    {
        $this->description = __('ship::command.test.description');
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            'run',
            null,
            InputOption::VALUE_OPTIONAL,
            __('ship::command.test.option.all'),
            self::ALL
        );

        $this->addOption(
            'component',
            null,
            InputOption::VALUE_OPTIONAL,
            __('ship::command.test.option.component'),
            self::ALL
        );
    }

    public function handle(): void
    {
        try {
            $this->processShip();
            $this->processSections();
            $this->showProfiler('Profiler');
            $this->outputPhpUnitTotal();
        } catch (Exception $e) {
            $this->showProfiler('Profiler');
        }
    }

    protected function processSections(): void
    {
        $this->doProcessAllSection();
        $this->doProcessOneSection();
        $this->doProcessOneSectionContainer();
    }

    protected function doProcessOneSectionContainer(): void
    {
        $result = $this->componentIsContainer();
        if (is_array($result)) {
            list($section, $container) = $result;
            if ($this->existsSection($section)) {
                if (in_array($container, Apiato::getSectionContainerNames($section))) {
                    $this->processSectionContainer(
                        $section,
                        $this->getSectionPath($section),
                        $container
                    );
                }
            }
        }
    }

    protected function doProcessOneSection(): void
    {
        $section = $this->componentIsSection();
        if ($section !== false) {
            $this->processSection($section);
        }
    }

    protected function doProcessAllSection(): void
    {
        if ($this->componentIs(self::ALL)) {
            foreach (Apiato::getSectionNames() as $sectionName) {
                $this->processSection($sectionName);
            }
        }
    }

    protected function processShip(): void
    {
        if ($this->componentIs('Ship') || $this->componentIs(self::ALL)) {
            $this->info(__('ship::command.test.process', [
                'component' => 'Ship'
            ]));

            $this->runVariants(app_path('Ship'));
        }
    }

    protected function processSection(string $sectionName): void
    {
        $sectionPath = $this->getSectionPath($sectionName);
        foreach (Apiato::getSectionContainerNames($sectionName) as $containerName) {
            $this->processSectionContainer($sectionName, $sectionPath, $containerName);
        }
    }

    protected function getSectionPath(string $sectionName): string
    {
        return app_path('Containers/' . $sectionName);
    }

    protected function processSectionContainer(string $sectionName, string $sectionPath, string $containerName)
    {
        $containerPath = $sectionPath . '/' . $containerName;

        $this->info(__('ship::command.test.process', [
            'component' => $sectionName . '@' . $containerName
        ]));

        $this->runVariants($containerPath);
    }

    protected function runVariants(string $path): void
    {
        if ($this->runIs(self::ALL) || $this->runIs(self::OPTION_RUN_PHPMD)) {
            $this->runPhpMd($path);
        }

        if ($this->runIs(self::ALL) || $this->runIs(self::OPTION_RUN_PHPCS)) {
            $this->runPhpCs($path);
        }

        if ($this->runIs(self::ALL) || $this->runIs(self::OPTION_RUN_PHPUNIT)) {
            $this->runPhpUnit($path);
        }
    }

    protected function runIs(string $value): bool
    {
        $variants = explode(',', $this->getOption('run'));
        return in_array($value, $variants);
    }

    protected function componentIsSection(): string|false
    {
        $component = $this->getOption('component');
        if ($this->existsSection($component)) {
            return $component;
        }

        return false;
    }

    protected function existsSection(string $section): bool
    {
        return in_array($section, Apiato::getSectionNames());
    }

    protected function componentIsContainer(): array|false
    {
        $component = $this->getOption('component');
        if (str_contains($component, '@')) {
            return explode('@', $component);
        }

        return false;
    }

    protected function componentIs(string $value): bool
    {
        $component = $this->getOption('component');
        return Str::lower($component) === Str::lower($value);
    }

    public function runPhpMd(string $path): void
    {
        $command = [
            $this->getPhpExecutable(),
            $this->getPhpMdExecutable(),
            $path,
            'text',
            './phpmd.xml'
        ];

        $this->runProcess($command, __('ship::command.test.launch', [
            'component' => 'PHP Mess Detector'
        ]));
    }

    public function runPhpCs(string $path): void
    {
        $command = [
            $this->getPhpExecutable(),
            $this->getPhpCsExecutable(),
            $path,
            '--standard=./phpcs.xml'
        ];

        $this->runProcess($command, __('ship::command.test.launch', [
            'component' => 'PHP Code Sniffer'
        ]));
    }

    public function runPhpUnit(string $path)
    {
        $testPath = $path . '/Tests';

        if (File::isDirectory($testPath)) {
            $command = [
                $this->getPhpExecutable(),
                $this->getPhpUnitExecutable(),
                '--configuration',
                base_path('phpunit.xml'),
                $testPath
            ];

            $this->runProcess($command, __('ship::command.test.launch', [
                'component' => 'PhpUnit'
            ]));
        } else {
            $this->label(__('ship::command.test.phpunit.no_tests'));
        }
    }

    protected function label(string $text): void
    {
        $this->info('- ' . $text);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function runProcess(array $command, string $label): void
    {
        $this->label($label);

        $process = new Process($command);
        $process->setTimeout(3600);

        $this->line('<question>' . $process->getCommandLine() . '</question>');

        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        } else {
            $this->onSuccessPhpUnitProcess($process);
        }
    }

    protected function onSuccessPhpUnitProcess(Process $process): void
    {
        if (str_contains($process->getCommandLine(), $this->getPhpUnitExecutable())) {
            $lines = collect(explode("\r\n", $process->getOutput()));

            $finishLine = $lines
                ->first(
                    fn (string $line) => preg_match('/^OK/', $line)
                );

            $testAndAssertionValues = str_replace([
                'OK',
                ' ',
                'tests',
                'assertions',
                '(',
                ')'
            ], null, $finishLine);

            list($tests, $assertions) = explode(',', $testAndAssertionValues);

            $this->phpUnitTotalTests += (int)$tests;
            $this->phpUnitTotalAssertions += (int)$assertions;
        }
    }

    protected function outputPhpUnitTotal(): void
    {
        if ($this->phpUnitTotalTests + $this->phpUnitTotalAssertions > ZERO) {
            $this->out->writeln([
                '<question>',
                '----=PHP Unit Total=----',
                $this->phpUnitTotalTests . ' tests',
                $this->phpUnitTotalAssertions . ' assertions',
                '</question>'
            ]);
        }
    }

    protected function getPhpUnitExecutable(): string
    {
        return base_path('vendor/phpunit/phpunit/phpunit');
    }

    protected function getPhpMdExecutable(): string
    {
        return base_path('vendor/phpmd/phpmd/src/bin/phpmd');
    }

    protected function getPhpCsExecutable(): string
    {
        return base_path('vendor/squizlabs/php_codesniffer/bin/phpcs');
    }

    protected function getPhpExecutable(): string
    {
        return PHP_BINARY;
    }
}
