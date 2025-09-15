<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Ship\Events;

use App\Ship\Parents\Requests\Request;

class RequestInitializeEvent
{
    public function __construct(protected Request $request)
    {
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}
