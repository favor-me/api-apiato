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

namespace App\Ship\Tests\Unit;

use App\Ship\Tests\UnitTestCase;
use Symfony\Component\Finder\Finder;

final class CodeStyleTest extends UnitTestCase
{
    protected string $packageName = 'Beauty application system';
    protected string $packageLicense = 'Proprietary';
    protected string $packageCopyright = 'Copyright (C) kalistratov.ru, All rights reserved.';
    protected string $packageLink = 'https://kalistratov.ru';
    protected string $packageAuthor = '';
    protected string $le = "\n";
    protected array $replace = [];

    protected array $packageDesc = [
        'This file is part of the Beauty application system package.',
        'For the full copyright and license information, please view the LICENSE',
        'file that was distributed with this source code.',
    ];

    protected array $excludePaths = [
        '.git',
        '.idea',
        'bin',
        'bower_components',
        'build',
        'fonts',
        'cache',
        'fixtures',
        'logs',
        'storage',
        'node_modules',
        'Containers/Vendor',
        'resources',
        'vendor',
        'temp',
        'tmp',
    ];

    protected array $validHeaderPHP = [
        '<?php',
        '',
        '/**',
        ' * _PACKAGE_',
        ' *',
        ' * _DESCRIPTION_PHP_',
        ' *',
        ' * @license     _LICENSE_',
        ' * @copyright   _COPYRIGHTS_',
        ' * @link        _LINK_',
    ];

    public function setUp(): void
    {
        parent::setUp();

        $this->replace = [
            '_LINK_' => $this->packageLink,
            '_COPYRIGHTS_' => $this->packageCopyright,
            '_PACKAGE_' => $this->packageName,
            '_LICENSE_' => $this->packageLicense,
            '_AUTHOR_' => $this->packageAuthor,
            '_DESCRIPTION_PHP_' => implode($this->le . ' * ', $this->packageDesc),
        ];
    }

    public function testHeadersPHP(): void
    {
        $valid = $this->prepareTemplate(implode($this->le, $this->validHeaderPHP));

        $finder = new Finder();
        $finder
            ->files()
            ->in($this->getProjectRoot())
            ->exclude($this->excludePaths)
            ->notName('/\.blade\.php/')
            ->notName('/artisan\.php/')
            ->notName('/_ide_helper\.php/')
            ->notName('/phpstorm\.meta\.php/')
            ->name('*.php');

        foreach ($finder as $file) {
            $content = $this->openFile($file->getPathname());
            $this->assertStringContainsString($valid, $content, 'File gas no valid header: ' . $file);
        }

        $this->assertTrue(true);
    }

    protected function getProjectRoot(): string
    {
        return realpath('.');
    }

    protected function prepareTemplate(string $text): string
    {
        foreach ($this->replace as $const => $value) {
            $text = str_replace($const, $value, $text);
        }

        return $text;
    }

    private function openFile($path): bool|string|null
    {
        $contents = null;

        if ($realPath = realpath($path)) {
            $fileSize = filesize($realPath);

            if ($fileSize > 0) {
                $handle = fopen($realPath, 'rb');
                $contents = fread($handle, $fileSize);
                fclose($handle);
            }
        }

        return $contents;
    }
}
