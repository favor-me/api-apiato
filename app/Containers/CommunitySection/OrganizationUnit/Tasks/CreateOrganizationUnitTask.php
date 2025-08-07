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

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Dto\CreateOrganizationUnitDto;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class CreateOrganizationUnitTask extends OrganizationUnitTask
{
    /**
     * @param CreateOrganizationUnitDto $dto
     * @return OrganizationUnit
     * @throws CreateResourceFailedException
     */
    public function run(CreateOrganizationUnitDto $dto): OrganizationUnit
    {
        try {
            return $this->create($dto);
        } catch (Exception $exception) {
            $this->errorCreate($exception);
        }
    }

    /**
     * @param CreateOrganizationUnitDto $dto
     * @return OrganizationUnit
     * @throws ValidatorException
     */
    protected function create(CreateOrganizationUnitDto $dto): OrganizationUnit
    {
        return $this->repository->create($dto->toArray());
    }

    /**
     * @param Exception $exception
     * @throws CreateResourceFailedException
     */
    protected function errorCreate(Exception $exception): void
    {
        throw new CreateResourceFailedException($exception->getMessage());
    }
}
