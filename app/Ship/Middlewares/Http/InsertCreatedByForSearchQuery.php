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

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Middlewares\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsertCreatedByForSearchQuery extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user instanceof User) {
            $this->setCreatedByIfEmpty($request);
        }

        $this->mapSearchDetails($request);

        return $next($request);
    }

    protected function mapSearchDetails(Request &$request): self
    {
        $searchKey = $this->getRequestSearchKey();
        $search = $request->get($searchKey, null);

        if (preg_match('/created_by:\*/', $search)) {
            $searchDetails = explode(';', $search);
            foreach ($searchDetails as $i => $searchDetail) {
                list ($field) = explode(':', $searchDetail);
                if ($field === 'created_by') {
                    unset($searchDetails[$i]);
                    break;
                }
            }

            $request->query->set($searchKey, implode(';', $searchDetails));
        }

        return $this;
    }

    protected function setCreatedByIfEmpty(Request &$request): self
    {
        $user = Auth::user();
        $searchKey = $this->getRequestSearchKey();
        $search = $request->get($searchKey, null);
        if (!preg_match('/created_by/', $search)) {
            $searchDetails = explode(';', $search);
            array_push($searchDetails, 'created_by:' . $user->getHashedKey());
            $request->query->set($searchKey, implode(';', $searchDetails));
        }

        return $this;
    }

    private function getRequestSearchKey(): string
    {
        return config('repository.criteria.params.search', 'search');
    }
}
