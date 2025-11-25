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

namespace App\Ship\Transformers;

use App\Ship\Parents\Transformers\Transformer;
use Illuminate\Support\Facades\Auth;

abstract class TransformerManager
{
    abstract public function getDefault(): Transformer;

    abstract public function getAdmin(): Transformer;

    public function getToList(): ?Transformer
    {
        return null;
    }

    public function getDefaultOrAdmin(): ?Transformer
    {
        return $this->canUseAdminTransformer() ? $this->getAdmin() : $this->getDefault();
    }

    public function canUseAdminTransformer(): bool
    {
        if (app()->environment('local')) {
            return true;
        }

        $user = Auth::user();

        return !is_null($user) && $user->is_admin === true;
    }
}
