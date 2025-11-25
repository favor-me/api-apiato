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

namespace App\Containers\OrganizationSection\UnitPrice\Traits;

use App\Containers\OrganizationSection\UnitPrice\Map\Manager;
use App\Containers\OrganizationSection\UnitPrice\Map\Type;

trait UnitPriceList
{
    protected ?string $priceListModel = null;
    protected ?int $priceListModelId = null;

    public function priceList(?string $model = null, ?int $modelId = null): self
    {
        $this->priceListModel = $model;
        $this->priceListModelId = $modelId;

        return $this;
    }

    public function getPriceListModelType(): Type
    {
        return $this->getPriceListManager()
            ->get($this->priceListModel);
    }

    public function getPriceListManager(): Manager
    {
        return Manager::getInstance();
    }
}
