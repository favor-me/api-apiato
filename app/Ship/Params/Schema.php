<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Ship\Params;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Schema
{
    protected Collection $elements;

    public function __construct(
        protected Model $model
    ) {
        $this->elements = collect();
        $this->build();
    }

    abstract public function build(): void;

    public function getElements(): Collection
    {
        return $this->elements;
    }
}
