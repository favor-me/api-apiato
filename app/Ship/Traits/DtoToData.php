<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link        https://kalistratov.ru
 * @author      Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Ship\Traits;

use ReflectionClass;

trait DtoToData
{
    public function toData(): array
    {
        return $this->isToUpdate() ? $this->toUpdateData() : $this->toArray();
    }

    protected function toUpdateData(): array
    {
        return $this
            ->except(ID)
            ->toArray(true);
    }

    protected function isToUpdate(): bool
    {
        $reflection = new ReflectionClass($this);
        return str_starts_with($reflection->getShortName(), 'Update');
    }
}
