<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Ship\Parents\Requests;

use Apiato\Core\Abstracts\Requests\Request as AbstractRequest;
use App\Containers\AppSection\User\Models\User;

/**
 * @method null|User user($guard = null)
 */
abstract class Request extends AbstractRequest
{
    public const FORCE_DELETE = 'force-delete';
    public const WITH_TRASHED = 'with-trashed';
    public const ONLY_TRASHED = 'only-trashed';

    public function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->afterInitialize();
    }

    public function takeWithTrashed(): bool
    {
        return $this->get('take') === self::WITH_TRASHED;
    }

    public function takeOnlyTrashed(): bool
    {
        return $this->get('take') === self::ONLY_TRASHED;
    }

    public function isOnlyTrashed(): bool
    {
        return $this->boolean(self::ONLY_TRASHED) === true;
    }

    public function isForceDelete(): bool
    {
        return $this->boolean(self::FORCE_DELETE) === true;
    }

    protected function afterInitialize(): void
    {
    }
}
