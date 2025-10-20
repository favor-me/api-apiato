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

use App\Ship\Foundation\SectionContainer;

class ModelEvent extends SectionContainer
{
    public const DEFAULT_DATABASE = 'zmch_erp_events';
    public const MODEL = 'model';
    public const MODEL_ID = 'model_id';
    public const TYPE = 'type';
    public const EVENT_TYPE_ALIAS = 'event_type';
    public const DATA = 'data';
    public const DATA_CHANGES = 'data_changes';
    public const API_URI_ALL_TYPES = 'types/all';

    protected string $apiBaseUri = 'model-events';
}
