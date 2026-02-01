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

namespace App\Containers\AppSection\Authentication\Password;

interface TokenRepositoryInterface
{
    public function create(CanResetPassword $user): string;

    public function exists(CanResetPassword $user, string $token): bool;

    public function recentlyCreatedToken(CanResetPassword $user): bool;

    public function delete(CanResetPassword $user): void;

    public function deleteExpired(): void;
}
