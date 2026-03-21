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
    public const string TYPE = 'type';
    public const string MODEL = 'model';
    public const string MODEL_SHORT = 'model_short';
    public const string MODEL_ID = 'model_id';
    public const string EVENT_ID = 'event_id';
    public const string INCLUDE_EVENT = 'event';
    public const string INCLUDE_MODEL_NOTES = 'model_notes';

    protected string $apiBaseUri = 'model-notes';
}
