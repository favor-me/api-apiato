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

namespace App\Containers\CommunitySection\OrganizationClient\Traits;

use App\Containers\CommunitySection\OrganizationClient\Facades\Container;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;

trait OrganizationClientValidationRules
{
    public function getOrganizationClientIdValidationRules(): ValidationRules
    {
        return validation_rules([
            'nullable',
            $this->getOrganizationClientIdExistsValidationRule(ID)
        ]);
    }

    public function getOrganizationClientNameValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . OrganizationClient::NAME));
    }

    public function getOrganizationClientPatronymicValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . OrganizationClient::PATRONYMIC));
    }

    public function getOrganizationClientSurnameValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . OrganizationClient::SURNAME));
    }

    public function getOrganizationClientPhoneNumberValidationRules(): ValidationRules
    {
        return validation_rules(
            Container::getConfig('rules.' . OrganizationClient::PHONE_NUMBER)
        )->add($this->getOrganizationClientPhoneNumberUnique());
    }

    public function getOrganizationClientNoteValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . OrganizationClient::NOTE));
    }

    public function getOrganizationClientPhoneNumberUnique(string $column = 'NULL'): Unique
    {
        return Rule::unique(OrganizationClientModel::TABLE, $column)
            ->where(OrganizationClient::ORGANIZATION_ID, $this->organization_id);
    }

    public function getOrganizationClientIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return Rule::exists(OrganizationClientModel::TABLE, $column)
            ->where(OrganizationClient::ORGANIZATION_ID, $this->organization_id);
    }
}
