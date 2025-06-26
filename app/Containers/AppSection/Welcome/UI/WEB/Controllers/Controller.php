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

namespace App\Containers\AppSection\Welcome\UI\WEB\Controllers;

use App\Ship\Parents\Controllers\WebController;
use Illuminate\View\View;

final class Controller extends WebController
{
    public function welcome(): View
    {
        return auth()->check() ? $this->homePrivate() : $this->homePublic();
    }

    protected function homePublic(): View
    {
        return view('appSection@welcome::home-public', [
            'pageTitle' => __('appSection@welcome::welcome.page_title')
        ]);
    }

    protected function homePrivate(): View
    {
        return view('appSection@welcome::home-private', [
            'pageTitle' => __('appSection@welcome::welcome.page_title')
        ]);
    }
}
