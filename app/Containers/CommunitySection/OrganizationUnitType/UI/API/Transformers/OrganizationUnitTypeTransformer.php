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

namespace App\Containers\CommunitySection\OrganizationUnitType\UI\API\Transformers;

use App\Containers\CommunitySection\OrganizationUnitType\Type;
use App\Ship\Parents\Transformers\Transformer;

class OrganizationUnitTypeTransformer extends Transformer
{
    public function transform(Type $type): array
    {
        return [
            'name' => $type->getName(),
            'title' => $type->getTitle()
        ];
    }
}
