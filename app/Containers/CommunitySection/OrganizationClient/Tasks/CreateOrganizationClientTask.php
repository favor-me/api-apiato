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

namespace App\Containers\CommunitySection\OrganizationClient\Tasks;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Dto\CreateOrganizationClientDto;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class CreateOrganizationClientTask extends OrganizationClientTask
{
    /**
     * @param CreateOrganizationClientDto $dto
     * @return OrganizationClient
     * @throws CreateResourceFailedException
     */
    public function run(CreateOrganizationClientDto $dto): OrganizationClient
    {
        try {
            return $this->create($dto);
        } catch (Exception $exception) {
            $this->errorCreate($exception);
        }
    }

    /**
     * @param CreateOrganizationClientDto $dto
     * @return OrganizationClient
     * @throws ValidatorException
     */
    protected function create(CreateOrganizationClientDto $dto): OrganizationClient
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
