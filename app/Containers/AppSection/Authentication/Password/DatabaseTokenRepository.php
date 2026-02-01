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

use App\Containers\AppSection\Authentication\Password\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DatabaseTokenRepository implements TokenRepositoryInterface
{
    /**
     * The database connection instance.
     */
    protected ConnectionInterface $connection;

    /**
     * The Hasher implementation.
     */
    protected Hasher $hasher;

    /**
     * The token database table.
     */
    protected string $table;

    /**
     * The hashing key.
     */
    protected string $hashKey;

    /**
     * The number of seconds a token should last.
     */
    protected int $expires;

    /**
     * Minimum number of seconds before re-redefining the token.
     */
    protected int $throttle;

    public function __construct(
        ConnectionInterface $connection,
        Hasher $hasher,
        $table,
        $hashKey,
        $expires = 60,
        $throttle = 60
    ) {
        $this->table = $table;
        $this->hasher = $hasher;
        $this->hashKey = $hashKey;
        $this->expires = $expires * 60;
        $this->connection = $connection;
        $this->throttle = $throttle;
    }

    public function create(CanResetPassword $user): string
    {
        $this->deleteExisting($user);

        $token = $this->createNewToken();

        $this
            ->getTable()
            ->insert(
                $this->getPayload($user, $token)
            );

        return $token;
    }

    public function exists(CanResetPassword $user, string $token): bool
    {
        $record = (array)$this
            ->getTable()
            ->where('column', $user->getColumnNameForPasswordReset())
            ->where('value', $user->getColumnValueForPasswordReset())
            ->first();

        return $record &&
            !$this->tokenExpired($record['created_at']) &&
            $this->hasher->check($token, $record['token']);
    }

    public function recentlyCreatedToken(CanResetPassword $user): bool
    {
        return true;
    }

    public function delete(CanResetPassword $user): void
    {
        $this->deleteExisting($user);
    }

    public function deleteExpired(): void
    {
        $expiredAt = Carbon::now()->subSeconds($this->expires);

        $this
            ->getTable()
            ->where('created_at', '<', $expiredAt)
            ->delete();
    }

    public function createNewToken(): string
    {
        return hash_hmac('sha256', Str::random(40), $this->hashKey);
    }

    protected function tokenExpired(string $createdAt): bool
    {
        return Carbon::parse($createdAt)
            ->addSeconds($this->expires)
            ->isPast();
    }

    protected function getPayload(CanResetPassword $user, $token): array
    {
        return [
            'created_at' => new Carbon(),
            'token' => $this->hasher->make($token),
            'column' => $user->getColumnNameForPasswordReset(),
            'value' => $user->getColumnValueForPasswordReset()
        ];
    }

    protected function deleteExisting(CanResetPasswordContract $user): int
    {
        return $this->getTable()
            ->where('column', $user->getColumnNameForPasswordReset())
            ->where('value', $user->getColumnValueForPasswordReset())
            ->delete();
    }

    protected function getTable(): Builder
    {
        return $this->connection->table($this->table);
    }
}
