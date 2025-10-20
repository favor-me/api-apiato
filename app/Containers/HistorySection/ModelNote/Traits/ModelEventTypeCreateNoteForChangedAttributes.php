<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\HistorySection\ModelNote\Traits;

use App\Ship\Exceptions\CreateResourceFailedException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait ModelEventTypeCreateNoteForChangedAttributes
{
    abstract public function getRelationAttributes(): array;

    abstract public function getModelNoteTypeParamsForChangedAttribute(
        mixed $field,
        mixed $oldValue,
        mixed $newValue
    ): array;

    /**
     * @return void
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    protected function createModelNote(): void
    {
        $changes = collect($this->getDataChanges());
        if ($changes->isEmpty()) {
            parent::createModelNote();
        } else {
            $this->createModelNoteForChangedAttributes($changes);
        }
    }

    /**
     * @param Collection $changes
     * @return void
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    protected function createModelNoteForChangedAttributes(Collection $changes): void
    {
        $changes
            ->each(function ($newValue, $field) {
                $oldValue = $this->getModelData()->getAttribute($field);
                $this->prepareModelNoteChangedAttributeValues($field, $oldValue, $newValue);

                $this->getModelNoteType()
                    ->create(
                        $this->modelEvent,
                        $this->getModelNoteTypeParamsForChangedAttribute($field, $oldValue, $newValue)
                    );
            });
    }

    protected function prepareModelNoteChangedAttributeValues(mixed $field, mixed &$oldValue, mixed &$newValue): void
    {
        $oldValue = $this->getModelData()->getAttribute($field);

        if (in_array($field, $this->getRelationAttributes())) {
            $methodName = 'set' . Str::ucfirst(Str::camel($field)) . 'RelationAttributeValue';
            if (method_exists($this, $methodName)) {
                $this->$methodName($newValue, $oldValue);
            }
        }

        if (empty($oldValue)) {
            $oldValue = Str::lower(__('core.not_assigned'));
        }
    }
}
