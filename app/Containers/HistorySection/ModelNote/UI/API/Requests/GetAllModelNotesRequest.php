<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link        https://kalistratov.ru
 * @author      Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\HistorySection\ModelNote\UI\API\Requests;

use App\Containers\HistorySection\ModelNote\UI\API\Transformers\AdminModelNoteTransformer;
use App\Containers\HistorySection\ModelNote\UI\API\Transformers\ModelNoteTransformer;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

class GetAllModelNotesRequest extends ApiRequest implements GettableTransformer
{
    public function getTransformer(): Transformer
    {
        return $this->isAdminUser() ? new AdminModelNoteTransformer() : new ModelNoteTransformer();
    }
}
