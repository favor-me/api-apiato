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

namespace App\Containers\ShiftSection\Shift\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\ShiftSection\Shift\Dto\CreateShiftDto;
use App\Containers\ShiftSection\Shift\Exceptions\InvalidDateTimeException;
use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Containers\ShiftSection\Shift\Requests\ShiftApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use App\Ship\Exceptions\InvalidSystemDateFormatException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Support\Carbon as ShiftCarbon;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateShiftRequest extends ShiftApiRequest implements GettableDto
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    public function rules(): array
    {
        return [
            Shift::START_AT => $this->getShiftStartAtValidationRules(),
            Shift::FINISH_AT => $this->getShiftFinishAtValidationRules()
        ];
    }

    public function getShiftStartAtValidationRules(): ValidationRules
    {
        return parent::getShiftStartAtValidationRules()
            ->addRequired();
    }

    public function getShiftFinishAtValidationRules(): ValidationRules
    {
        return parent::getShiftFinishAtValidationRules()
            ->addRequired();
    }

    /**
     * @return CreateShiftDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateShiftDto
    {
        $data = $this->validated() + $this->commonDtoData();
        return $this->newDto($data);
    }

    /**
     * @param array $data
     * @return CreateShiftDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateShiftDto
    {
        return new CreateShiftDto($data);
    }

    public function messages(): array
    {
        return parent::messages() +
            [
                Shift::FINISH_AT . '.after' => Container::trans('container.validation.finish_at.after')
            ];
    }

    /**
     * @return void
     * @throws InvalidDateTimeException
     * @throws InvalidSystemDateFormatException
     * @throws NotFoundException
     */
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->checkNowShift();
    }

    /**
     * @return void
     * @throws InvalidDateTimeException
     * @throws InvalidSystemDateFormatException
     * @throws NotFoundException
     */
    protected function checkNowShift(): void
    {
        $user = app(FindUserByIdTask::class)->run($this->created_by);
        $nowShift = $user->nowShift;

        if ($nowShift) {
            $startAt = $this->get(Shift::START_AT);
            $finishAt = $this->get(Shift::FINISH_AT);

            $nowStartAt = $nowShift->start_at->getTimestamp();
            $nowFinishAt = $nowShift->finish_at->getTimestamp();

            $startAt = $this->systemDateTimeToTimestamp($startAt);
            $finishAt = $this->systemDateTimeToTimestamp($finishAt);

            $canDo = $startAt < $nowStartAt && $finishAt < $nowFinishAt;

            if (!$canDo) {
                throw new InvalidDateTimeException();
            }
        }
    }

    protected function commonDtoData(): array
    {
        $data = [
            CREATED_BY => $this->created_by,
            Shift::ORGANIZATION_ID => $this->organization_id,
            Shift::ORGANIZATION_BRANCH_ID => $this->organization_branch_id
        ];

        if ($this->get(Shift::EXCLUDE_ORGANIZATION_BRANCH)) {
            unset($data[Shift::ORGANIZATION_BRANCH_ID]);
        }

        return $data;
    }

    /**
     * @param string $dateTime
     * @return int
     * @throws InvalidSystemDateFormatException
     */
    protected function systemDateTimeToTimestamp(string $dateTime): int
    {
        return ShiftCarbon::createFromSystemDateTime($dateTime)->getTimestamp();
    }
}
