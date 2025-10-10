<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\OrderSection\Status\Requests;

use App\Containers\OrderSection\Status\Traits\StatusValidationRules;
use App\Containers\OrderSection\Status\UI\API\Transformers\AdminStatusTransformer;
use App\Containers\OrderSection\Status\UI\API\Transformers\StatusTransformer;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

abstract class StatusApiRequest extends ApiRequest implements GettableTransformer
{
    use StatusValidationRules;

    public function getTransformer(): Transformer
    {
        return $this->isAdminUser() ? new AdminStatusTransformer() : new StatusTransformer();
    }
}
