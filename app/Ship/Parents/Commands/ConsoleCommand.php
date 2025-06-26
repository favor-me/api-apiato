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

namespace App\Ship\Parents\Commands;

use Apiato\Core\Abstracts\Commands\ConsoleCommand as AbstractConsoleCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class ConsoleCommand extends AbstractConsoleCommand
{
    protected ?InputInterface $in;
    protected ?OutputInterface $out;

    /**
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    protected function getOption($name, $default = null): mixed
    {
        $value = $this->in->getOption($name);
        return null === $value ? $default : $value;
    }

    protected function progressBar($name, $total, $stepSize, $callback): void
    {
        $this->out->writeln(__('ship::command.progress_bar_name', ['name' => $name]));

        $total = (int)$total;
        $stepSize = (int)$stepSize;

        $progressBar = new ProgressBar($this->out, $total);
        $progressBar->display();
        $progressBar->setOverwrite(true);
        $progressBar->setRedrawFrequency(1);

        for ($currentStep = 0; $currentStep <= $total; $currentStep += $stepSize) {
            $callbackResult = $callback($currentStep, $stepSize);

            if ($callbackResult === false) {
                break;
            }

            $progressBar->setProgress($currentStep);
        }

        $progressBar->finish();
    }

    protected function showProfiler($label = null): void
    {
        //  Count Memory.
        $memoryCur = round(memory_get_usage(false) / 1024 / 1024, 2);
        $memoryCur = sprintf("%.02lf", round($memoryCur, 2));

        $memoryPeak = round(memory_get_peak_usage(false) / 1024 / 1024, 2);
        $memoryPeak = sprintf("%.02lf", round($memoryPeak, 2));

        //  Count time.
        $time = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
        $time = sprintf("%.02lf", round($time, 2));

        $this->out->writeln([
            '<question>',
            $label ? '----=' . $label . '=----' : ' ',
            'Memory: ' . $memoryCur . 'MB',
            'Mem.Peak: ' . $memoryPeak . 'MB',
            "Time: " . $time . 's',
            '</question>'
        ]);
    }

    protected function executePrepare(InputInterface $input, OutputInterface $output): void
    {
        $this->in = $input;
        $this->out = $output;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->executePrepare($input, $output);
        return parent::execute($input, $output);
    }
}
