<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\CommunitySection\Organization\Traits;

use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read null|OrganizationModel $organization Связанная модель организации.
 */
trait BelongsToOrganization
{
    protected string $foreignKeyBelongsToOrganization = 'organization_id';

    public function organization(): BelongsTo
    {
        return $this->belongsTo(OrganizationModel::class, $this->foreignKeyBelongsToOrganization, ID);
    }
}
