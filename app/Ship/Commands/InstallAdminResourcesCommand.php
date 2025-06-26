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

use App\Ship\Parents\Commands\ConsoleCommand;
use Illuminate\Support\Facades\File;

class InstallAdminResourcesCommand extends ConsoleCommand
{
    protected array $map = [
        'dist/js/adminlte.min.js' => 'js/adminlte.min.js',
        'dist/css/adminlte.min.css' => 'css/adminlte.min.css',
        'plugins/jquery/jquery.min.js' => 'js/jquery.min.js',
        'plugins/fontawesome-free/webfonts' => 'webfonts',
        'plugins/fontawesome-free/css/all.min.css' => 'css/fontawesome.min.css',
    ];

    protected function configure(): void
    {
        $this->setName('admin:install-resources');
    }

    public function handle(): void
    {
        $adminLteBasePath = base_path('vendor/almasaeed2010/adminlte');
        $adminPublicPath = base_path('admin');

        $this->makeResources($adminLteBasePath, $adminPublicPath);
    }

    protected function makeResources(string $fromPath, string $toPath)
    {
        if (File::isDirectory($fromPath)) {
            foreach ($this->map as $path => $target) {
                $vendorFullPath = $fromPath . "/{$path}";
                $projectFullPath = $toPath . "/{$target}";

                $this
                    ->createPathDirectories($vendorFullPath, $projectFullPath)
                    ->copyResources($vendorFullPath, $projectFullPath);
            }
        }
    }

    protected function copyResources(string $vendorFullPath, string $projectFullPath): self
    {
        if (File::isDirectory($vendorFullPath)) {
            File::copyDirectory($vendorFullPath, $projectFullPath);
        } else {
            File::copy($vendorFullPath, $projectFullPath);
        }

        return $this;
    }

    protected function createPathDirectories(string $vendorFullPath, string $projectFullPath): self
    {
        if (File::isDirectory($vendorFullPath)) {
            if (!File::isDirectory($projectFullPath)) {
                File::makeDirectory($projectFullPath);
            }
        } else {
            $targetDirPath = dirname($projectFullPath);
            if (!File::isDirectory($targetDirPath)) {
                File::makeDirectory($targetDirPath);
            }
        }

        return $this;
    }
}
