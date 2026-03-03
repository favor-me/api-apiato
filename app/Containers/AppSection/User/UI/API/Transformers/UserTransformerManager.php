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

namespace App\Containers\AppSection\User\UI\API\Transformers;

use App\Ship\Transformers\TransformerManager;

final class UserTransformerManager extends TransformerManager
{
    public function getDefault(): UserTransformer
    {
        return new UserTransformer();
    }

    public function getAdmin(): AdminUserTransformer
    {
        return new AdminUserTransformer();
    }

    public function getPrivateProfile(): ?UserPrivateProfileTransformer
    {
        return new UserPrivateProfileTransformer();
    }

    public function getToList(): ?UserToListTransformer
    {
        return new UserToListTransformer();
    }
}
