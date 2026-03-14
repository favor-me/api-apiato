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

namespace App\Containers\OrganizationSection\UnitPrice\UI\API\Requests;

use App\Containers\OrganizationSection\UnitPrice\Data\Repositories\UnitPriceRepository;
use App\Containers\OrganizationSection\UnitPrice\Dto\UpdateUnitPriceDto;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\ValidationFailedException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\Rules\Unique;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @method UpdateUnitPriceDto getDto()
 * @property-read mixed $unit_id
 */
class UpdateUnitPriceRequest extends CreateUnitPriceRequest
{
    protected function afterInitialize(): void
    {
        parent::afterInitialize();

        $this->mergeUrlParameters([
            UnitPrice::MODEL_ID,
            UnitPrice::UNIT_ID
        ]);
    }

    public function newDto(array $data = []): UpdateUnitPriceDto
    {
        return new UpdateUnitPriceDto($data);
    }

    public function getUnitPriceUnitIdUniqueValidationRule(): Unique
    {
        return $this->getModelType()
            ->uniqueUnitIdValidationRule(
                $this->model_id,
                $this->unit_id
            );
    }

    /**
     * @return array
     * @throws NotFoundException
     * @throws RepositoryException
     */
    protected function getDtoData(): array
    {
        $data = parent::getDtoData();

        $unitPrice = $this->getUnitPrice();

        if (is_null($unitPrice)) {
            throw new NotFoundException();
        }

        $data[ID] = $unitPrice->id;

        return $data;
    }

    /**
     * @return UnitPriceModel|null
     * @throws RepositoryException
     */
    protected function getUnitPrice(): ?UnitPriceModel
    {
        return app(UnitPriceRepository::class)
            ->pushCriteria(
                new ThisEqualThatCriteria(UnitPrice::MODEL, $this->getModelType()->getModelAccessor())
            )
            ->pushCriteria(
                new ThisEqualThatCriteria(UnitPrice::MODEL_ID, $this->model_id)
            )
            ->pushCriteria(
                new ThisEqualThatCriteria(UnitPrice::UNIT_ID, $this->unit_id)
            )
            ->first();
    }

    /**
     * @return bool
     * @throws AuthorizationException
     * @throws ValidationFailedException
     */
    protected function passesAuthorization(): bool
    {
        $result = parent::passesAuthorization();
        if ($result === true) {
            $this->throwIfEmptyInput();
        }

        return $result;
    }
}
