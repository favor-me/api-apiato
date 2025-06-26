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

namespace App\Containers\CommunitySection\Organization\Tasks;

use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\CommunitySection\Organization\Dto\UpdateOrganizationDto;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class UpdateOrganizationTask extends OrganizationTask
{
    /**
     * @param UpdateOrganizationDto $dto
     * @return Organization
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateOrganizationDto $dto): Organization
    {
        try {
            return $this->update($dto);
        } catch (Exception $exception) {
            $this->errorUpdate($exception);
        }
    }

    /**
     * @param UpdateOrganizationDto $dto
     * @return Organization
     * @throws ValidatorException
     */
    protected function update(UpdateOrganizationDto $dto): Organization
    {
        $data = $dto
            ->except(ID)
            ->toArray(true);

        return $this->repository->update($data, $dto->id);
    }

    /**
     * @param Exception $exception
     * @throws UpdateResourceFailedException
     */
    protected function errorUpdate(Exception $exception): void
    {
        throw new UpdateResourceFailedException($exception->getMessage());
    }
}
