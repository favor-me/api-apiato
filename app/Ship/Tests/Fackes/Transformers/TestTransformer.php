<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Ship\Tests\Fackes\Transformers;

use App\Ship\Parents\Transformers\Transformer;

class TestTransformer extends Transformer
{
    protected array $availableIncludes = [
        'fanny',
        'summer'
    ];

    public function transform($item): array
    {
        return [
            'description' => $item->description
        ];
    }
}
