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

namespace App\Containers\OrderSection\Order\Events;

use App\Containers\OrderSection\Order\Data\Repositories\OrderRepository;
use App\Ship\Criterias\InCriteria;
use App\Ship\Database\Eloquent\Collection;
use Prettus\Repository\Exceptions\RepositoryException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class OrdersEvent
{
    public function __construct(
        protected array $ids = []
    ) {
    }

    public function getIds(): array
    {
        return $this->ids;
    }

    /**
     * @return Collection
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RepositoryException
     */
    public function getOrders(): Collection
    {
        return app(OrderRepository::class)
            ->pushCriteria(new InCriteria($this->ids, ID))
            ->get();
    }
}
