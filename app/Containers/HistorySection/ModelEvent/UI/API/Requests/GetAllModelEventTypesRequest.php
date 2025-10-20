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

namespace App\Containers\HistorySection\ModelEvent\UI\API\Requests;

use App\Containers\HistorySection\ModelEvent\Requests\ModelEventApiRequest;
use App\Containers\HistorySection\ModelEvent\UI\API\Transformers\ModelEventTypeToListTransformer;
use App\Containers\HistorySection\ModelEvent\UI\API\Transformers\ModelEventTypeTransformer;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Contracts\IsListableRequest;
use App\Ship\Parents\Transformers\Transformer;

class GetAllModelEventTypesRequest extends ModelEventApiRequest implements GettableTransformer, IsListableRequest
{
    public function getTransformer(): Transformer
    {
        return !$this->isToList() ? new ModelEventTypeTransformer() : $this->getToListTransformer();
    }

    public function getToListTransformer(): Transformer
    {
        return new ModelEventTypeToListTransformer();
    }
}
