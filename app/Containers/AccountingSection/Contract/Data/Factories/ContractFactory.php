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

namespace App\Containers\AccountingSection\Contract\Data\Factories;

use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Support\Carbon;
use App\Ship\Traits\Factory\HasTrashedState;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Collection|ContractModel create($attributes = [], ?Model $parent = null)
 * @method Collection|ContractModel make($attributes = [], ?Model $parent = null)
 */
final class ContractFactory extends Factory
{
    use HasTrashedState;

    protected $model = ContractModel::class;

    public function definition(): array
    {
        $now = Carbon::now();

        return [
            Contract::COUNTERPARTY_ID => null,
            Contract::FINISH_AT => $now->addMonth(),
            Contract::NAME => $this->faker->title,
            Contract::NUMBER => null,
            Contract::ORGANIZATION_ID => null,
            Contract::START_AT => $now
        ];
    }

    public function counterparty(?int $organizationId = null): self
    {
        if (is_null($organizationId)) {
            $organizationId = Organization::factory()->create()->id;
        }

        $counterParty = CounterpartyModel::factory()
            ->rus()
            ->organization($organizationId)
            ->create();

        return $this->state(fn() => [
            Contract::COUNTERPARTY_ID => $counterParty->id,
            Contract::ORGANIZATION_ID => $organizationId
        ]);
    }
}
