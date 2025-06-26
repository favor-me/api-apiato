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

namespace App\Containers\AppSection\UserDevice\Tests\Functional;

use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Containers\AppSection\UserDevice\Tests\FunctionalTestCase;

abstract class ApiUnitTestCase extends FunctionalTestCase
{
    public function injectId($id, $skipEncoding = false, $replace = '{' . BaseUser::ID . '}'): static
    {
        return parent::injectId($id, $skipEncoding, $replace);
    }
}
