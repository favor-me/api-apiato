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

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\HistorySection\ModelEvent\Exceptions\NotFoundModelEventTypeException;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Foundation\AbstractManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\Finder\Finder;

/**
 * @method null|ModelEventType get(string $key)
 * @method static ModelEventManager getInstance()
 */
class ModelEventManager extends AbstractManager
{
    public const CONTAINER_EVENT_TYPE_PATH = 'History/Events';

    public const PREFIX = 'Event';

    /**
     * @param string|ModelEventType $eventType
     * @param array $data
     * @return void
     * @throws NotFoundModelEventTypeException
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    public function run(string|ModelEventType $eventType, array $data = []): void
    {
        if ($this->isItem($eventType)) {
            $eventType = $eventType::getType();
        }

        $eventTypeClass = $this->get($eventType);

        if (is_null($eventTypeClass)) {
            throw new NotFoundModelEventTypeException();
        }

        $eventTypeClass
            ->bindData($data)
            ->run();
    }

    public function getAllByType(string $classType): Collection
    {
        return $this
            ->all()
            ->filter(
                fn (ModelEventType $modelEventType) => is_subclass_of($modelEventType, $classType)
            );
    }

    public function getItemAccessor(): string
    {
        return ModelEventType::class;
    }

    protected function onRegisterItem(string $className): void
    {
        /** @var ModelEventType $eventType */
        $eventType = app($className);
        $this->items->put($eventType::getType(), $eventType);
    }

    public function getPaths(): array
    {
        $paths = [];

        foreach (Apiato::getAllContainerPaths() as $containerPath) {
            $containerEventTypePath = $containerPath . '/' . self::CONTAINER_EVENT_TYPE_PATH;
            if (File::isDirectory($containerEventTypePath)) {
                $paths[] = $containerEventTypePath;
            }
        }

        return $paths;
    }

    protected function findFiles(): Finder
    {
        return parent::findFiles()
            ->notName('/^' . self::PREFIX . '\.php/')
            ->name('*' . self::PREFIX . '.php');
    }
}
