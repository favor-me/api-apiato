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

namespace App\Ship\Parents\Collections;

use App\Ship\Parents\Models\Model;
use Illuminate\Support\Collection;
use Kalnoy\Nestedset\Collection as BaseNestedSetCollection;

class NestedSetCollection extends BaseNestedSetCollection
{
    public function forSelect(string $key = 'id', string $value = 'title'): Collection
    {
        return $this->pluck($value, $key);
    }

    public function toList(string $prefix = '-'): self
    {
        return new static($this->treeToList($this, 0, $prefix));
    }

    protected function treeToList(Collection $items, int $level = 0, string $prefix = '-'): array
    {
        $level++;

        $return = [];
        /** @var Model $item */
        foreach ($items as $item) {
            $newTitle = ($level === 1) ? $item->title : $prefix . $item->title;
            $children = $item->children;

            $item
                ->fill(['title' => $newTitle])
                ->unsetRelation('children');

            $return[] = $item;

            if ($children->count()) {
                $return = array_merge($return, $this->treeToList($children, $level, $prefix . $prefix));
            }
        }

        return $return;
    }
}
