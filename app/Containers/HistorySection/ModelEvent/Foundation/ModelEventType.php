<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    Proprietary
 * @copyright  Copyright (C) zemlechist.ru, All rights reserved.
 * @link       https://zemlechist.ru
 */

namespace App\Containers\HistorySection\ModelEvent\Foundation;

use App\Containers\HistorySection\ModelEvent\Actions\CreateModelEventAction;
use App\Containers\HistorySection\ModelEvent\Dto\CreateModelEventDto;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent as BaseModelEvent;
use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;
use App\Containers\HistorySection\ModelNote\Types\ModelNoteType;
use App\Ship\Contracts\Namebled;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Models\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

abstract class ModelEventType implements Namebled
{
    public const RESOURCE_KEY = 'ModelEventType';

    protected ?string $createdByForEventFromModelAttribute = null;

    public function __construct(
        protected Collection $data,
        protected ?ModelEvent $modelEvent
    ) {
        $this->initialize();
    }

    public function initialize(): void
    {
    }

    public function getModel(): string
    {
        return $this->getModelData()::class;
    }

    abstract public function getGroup(): string;

    public function getModelId(): int
    {
        return $this->getModelData()->getAttribute(ID);
    }

    abstract public function getDataChanges(): array;
    abstract public function getData(): array;

    abstract public function getModelNoteType(): ModelNoteType;
    abstract public function getModelNoteTypeParams(): array;

    /**
     * @return ModelEvent|null
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    public function run(): ?ModelEvent
    {
        $this->modelEvent = $this->createModelEvent();
        $this->createModelNote();

        return $this->modelEvent;
    }

    /**
     * @return CreateModelEventDto
     * @throws UnknownProperties
     */
    public function createEventDto(): CreateModelEventDto
    {
        $data = [
            BaseModelEvent::TYPE => static::getType(),
            BaseModelEvent::MODEL => $this->getModel(),
            BaseModelEvent::MODEL_ID => $this->getModelId(),
            BaseModelEvent::DATA => $this->getData(),
            BaseModelEvent::DATA_CHANGES => $this->getDataChanges(),
        ];

        //  Set created_by model event attribute from model data. Can set custom created_by attribute.
        if ($this->createdByForEventFromModelAttribute) {
            $data[CREATED_BY] = $this->getModelData()
                ->getAttribute(
                    $this->createdByForEventFromModelAttribute
                );
        }

        return new CreateModelEventDto($data);
    }

    public function getModelData(): ?Model
    {
        return $this->data->get(BaseModelEvent::MODEL);
    }

    public function bindData(array $data = []): self
    {
        foreach ($data as $key => $value) {
            $this->data->put($key, $value);
        }

        return $this;
    }

    public static function getType(): string
    {
        $reflectionEventType = new ReflectionClass(static::class);
        $name = str_replace(ModelEventManager::PREFIX, null, $reflectionEventType->getShortName());
        return Str::snake($name);
    }

    /**
     * @return ModelEvent
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    protected function createModelEvent(): ModelEvent
    {
        return app(CreateModelEventAction::class)->run($this->createEventDto());
    }

    /**
     * @return void
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    protected function createModelNote(): void
    {
        $this->getModelNoteType()->create($this->modelEvent, $this->getModelNoteTypeParams());
    }
}
