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

namespace App\Containers\CommunitySection\OrganizationBranch\Tasks;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Dto\CreateOrganizationBranchDto;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class CreateOrganizationBranchTask extends OrganizationBranchTask
{
    /**
     * @param CreateOrganizationBranchDto $dto
     * @return OrganizationBranch
     * @throws CreateResourceFailedException
     */
    public function run(CreateOrganizationBranchDto $dto): OrganizationBranch
    {
        try {
            return $this->create($dto);
        } catch (Exception $exception) {
            $this->errorCreate($exception);
        }
    }

    /**
     * @param CreateOrganizationBranchDto $dto
     * @return OrganizationBranch
     * @throws ValidatorException
     */
    protected function create(CreateOrganizationBranchDto $dto): OrganizationBranch
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
