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

namespace App\Containers\HistorySection\ModelNote\Foundation;

use App\Ship\Foundation\SectionContainer;

final class ModelNote extends SectionContainer
{
    public const DEFAULT_DATABASE = 'zmch_erp_notes';
    public const TYPE = 'type';
    public const MODEL = 'model';
    public const MODEL_ID = 'model_id';
    public const EVENT_ID = 'event_id';
    public const INCLUDE_EVENT = 'event';
    public const INCLUDE_MODEL_NOTES = 'model_notes';

    protected string $apiBaseUri = 'model-notes';
}
