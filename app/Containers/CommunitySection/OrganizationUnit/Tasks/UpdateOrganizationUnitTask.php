<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Tasks;

use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Dto\UpdateOrganizationUnitDto;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class UpdateOrganizationUnitTask extends OrganizationUnitTask
{
    /**
     * @param UpdateOrganizationUnitDto $dto
     * @return OrganizationUnit
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateOrganizationUnitDto $dto): OrganizationUnit
    {
        try {
            return $this->update($dto);
        } catch (Exception $exception) {
            $this->errorUpdate($exception);
        }
    }

    /**
     * @param UpdateOrganizationUnitDto $dto
     * @return OrganizationUnit
     * @throws ValidatorException
     */
    protected function update(UpdateOrganizationUnitDto $dto): OrganizationUnit
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
