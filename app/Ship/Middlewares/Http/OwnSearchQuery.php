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

namespace App\Ship\Middlewares\Http;

use App\Ship\Parents\Middlewares\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnSearchQuery extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $searchKey = $this->getRequestSearchKey();
        $search = $request->get($searchKey, null);

        $request->query->set($searchKey, $this->toOwnSearchQuery($search));

        return $next($request);
    }

    private function getRequestSearchKey(): string
    {
        return config('repository.criteria.params.search', 'search');
    }

    private function toOwnSearchQuery(?string $search): string
    {
        $user = Auth::user();
        $searchDetails = explode(';', $search);

        if (!preg_match('/created_by/', $search)) {
            array_push($searchDetails, 'created_by:' . $user->getHashedKey());
        } else {
            foreach ($searchDetails as $i => $searchDetail) {
                list ($field) = explode(':', $searchDetail);
                if ($field === 'created_by' && !$user->is_admin) {
                    $searchDetails[$i] = implode(':', [$field, $user->getHashedKey()]);
                    break;
                }
            }
        }

        return implode(';', $searchDetails);
    }
}
