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

namespace App\Containers\HistorySection\ModelNote\Types;

use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;
use App\Containers\HistorySection\ModelNote\Dto\CreateModelNoteDto;
use App\Containers\HistorySection\ModelNote\Facades\Container;
use App\Containers\HistorySection\ModelNote\Models\ModelNote;
use App\Containers\HistorySection\ModelNote\Foundation\ModelNote as BaseModelNote;
use App\Ship\Contracts\Namebled;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\HistorySection\ModelNote\Tasks\CreateModelNoteTask;
use Illuminate\Contracts\Support\Arrayable;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use ReflectionClass;
use Illuminate\Support\Str;

abstract class ModelNoteType implements Namebled, Arrayable
{
    public const NAME = 'name';
    public const TITLE = 'title';

    private string $name;

    public function __construct()
    {
        $this->name = self::getKey();
    }

    public static function getKey(): string
    {
        $reflectionType = new ReflectionClass(static::class);
        $name = str_replace(ModelNoteTypeManager::PREFIX, '', $reflectionType->getShortName());
        return Str::snake($name);
    }

    abstract public function factoryParamsDefinition(array $params = []): array;

    /**
     * @param ModelEvent $modelEvent
     * @param array $params
     * @return ModelNote
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    public function create(ModelEvent $modelEvent, array $params): ModelNote
    {
        return app(CreateModelNoteTask::class)->run(
            $this->getCreateModelNoteDto($modelEvent, $params)
        );
    }

    /**
     * @param ModelEvent $modelEvent
     * @param array $params
     * @return CreateModelNoteDto
     * @throws UnknownProperties
     */
    protected function getCreateModelNoteDto(ModelEvent $modelEvent, array $params): CreateModelNoteDto
    {
        $params = $this->prepareModelNoteParams($params);

        $data = [
            BaseModelNote::TYPE => $this->getName(),
            BaseModelNote::MODEL => $modelEvent->model,
            BaseModelNote::MODEL_ID => $modelEvent->model_id,
            BaseModelNote::EVENT_ID => $modelEvent->id,
            PARAMS => $params
        ];

        if (!empty($modelEvent->created_by)) {
            $data[CREATED_BY] = $modelEvent->created_by;
        }

        return new CreateModelNoteDto($data);
    }

    protected function prepareModelNoteParams(array $params): array
    {
        foreach (array_keys($params) as $key) {
            if (!in_array($key, $this->getAllowedParamKeys())) {
                unset($params[$key]);
            }
        }

        return $params;
    }

    abstract public function getAllowedParamKeys(): array;

    public function getName(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            self::NAME => $this->name,
            self::TITLE => $this->getTitle()
        ];
    }

    public function getTitle(): string
    {
        return Container::trans('container.types.' . $this->getName() . '.title');
    }
}
