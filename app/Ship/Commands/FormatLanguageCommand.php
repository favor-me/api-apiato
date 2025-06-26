<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license Proprietary
 * @copyright Copyright (C) kalistratov.ru, All rights reserved.
 * @link https://kalistratov.ru
 */

namespace App\Ship\Commands;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Commands\ConsoleCommand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FormatLanguageCommand extends ConsoleCommand
{
    private const TAB = '    ';
    protected $description = 'Format language files.';
    protected $signature = 'lang:format';
    protected int $totalProcess = ZERO;

    public function handle(): void
    {
        $this->processShipLanguages();
        $this->processSectionContainerLanguages();

        if ($this->totalProcess <= ZERO) {
            $this->info('No find any languages files');
        } else {
            $this->info('Find and process ' . $this->totalProcess . ' language locales');
        }
    }

    protected function encode(array $data): string
    {
        $content = $this->render($data);
        $header = config('formatter.language.php_file_header');

        if ($this->excessLengthIsExists($content)) {
            $header = array_merge($header, [
                '',
                '// @codingStandardsIgnoreStart'
            ]);
        }

        $header = implode("\n", $header);

        $data = [
            '<?php',
            '',
            $header,
            '',
            'return ' . $content . ';',
            ''
        ];

        return implode("\n", $data);
    }

    protected function excessLengthIsExists(string $content): bool
    {
        $strMaxLength = 120;
        foreach (explode("\n", $content) as $line) {
            if (Str::length($line) > $strMaxLength) {
                return true;
            }
        }

        return false;
    }

    protected function findAndSortLocales(string $languagePath, $onSuccessCallback = null): void
    {
        $pathStorage = Storage::build($languagePath);
        $languages = $pathStorage->directories();
        foreach ($languages as $language) {
            foreach ($pathStorage->files($language) as $langLocaleFile) {
                $langFile = $languagePath . '/' . $langLocaleFile;
                if (is_file($langFile)) {
                    $locales = require $langFile;
                    if (is_array($locales)) {
                        $this->deepSort($locales);
                        $pathStorage->put($langLocaleFile, $this->encode($locales));
                        if (is_callable($onSuccessCallback)) {
                            call_user_func($onSuccessCallback, $langLocaleFile);
                        } else {
                            $this->line('Success process file is ' . $langFile);
                        }
                    }
                }
            }
        }
    }

    protected function deepSort(array &$array, string $function = 'ksort'): void
    {
        $function($array);
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $this->deepSort($array[$k], $function);
            }
        }
    }

    protected function getIndent(int $depth): string
    {
        return str_repeat(self::TAB, $depth);
    }

    protected function processSectionContainerLanguages(): void
    {
        foreach (Apiato::getSectionNames() as $sectionName) {
            foreach (Apiato::getSectionContainerNames($sectionName) as $containerName) {
                $path = base_path('app/Containers/' . $sectionName . '/' . $containerName . '/Languages');
                if (is_dir($path)) {
                    $this->findAndSortLocales($path, function ($langLocaleFile) use ($sectionName, $containerName) {
                        $this->line('Success process of ' . implode(null, [
                                $sectionName,
                                '@',
                                $containerName,
                                '::',
                                $langLocaleFile
                            ]));

                        $this->totalProcess++;
                    });
                }
            }
        }
    }

    protected function processShipLanguages(): void
    {
        $path = base_path('app/Ship/Languages');
        if (is_dir($path)) {
            $this->findAndSortLocales($path, function ($langLocaleFile) {
                $this->line('Success process of ship::' . $langLocaleFile);
                $this->totalProcess++;
            });
        }
    }

    protected function quoteWrap(string $var): string
    {
        $type = strtolower(gettype($var));

        switch ($type) {
            case 'string':
                return "'" . str_replace("'", "\\'", $var) . "'";

            case 'null':
                return 'null';

            case 'boolean':
                return $var ? 'true' : 'false';

            //TODO: handle other variable types.. ( objects? )
            case 'integer':
            case 'double':
        }

        return $var;
    }

    protected function render(array $array, int $depth = ZERO): string
    {
        $data = $array;
        $string = '[' . "\n";

        $depth++;
        foreach ($data as $key => $val) {
            $string .= $this->getIndent($depth) . $this->quoteWrap($key) . ' => ';
            if (is_array($val) || is_object($val)) {
                $string .= $this->render($val, $depth) . ',' . "\n";
            } else {
                $string .= $this->quoteWrap($val) . ',' . "\n";
            }
        }

        $depth--;
        $string .= $this->getIndent($depth) . ']';

        return $string;
    }
}
