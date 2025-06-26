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

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Ship\Parents\Middlewares\Middleware;
use App\Ship\Exceptions\MissingJSONHeaderException;

/**
 * Class ValidateJsonContent
 *
 * @package App\Ship\Middlewares\Http
 */
class ValidateJsonContent extends Middleware
{
    /**
     * Handle.
     *
     * @param   Request $request
     * @param   Closure $next
     *
     * @return  mixed
     *
     * @throws  MissingJSONHeaderException
     */
    public function handle(Request $request, Closure $next)
    {
        $acceptHeader = $request->header('accept');
        $contentType = 'application/json';

        // check if the accept header is set to application/json
        if (strpos($acceptHeader, $contentType) === false) {
            // if forcing users to have the accept header is enabled, then throw an exception
            if (Config::get('apiato.requests.force-accept-header')) {
                throw new MissingJSONHeaderException();
            }
        }

        // the request has to be processed, so get the response after the request is done
        $response = $next($request);

        // set Content Languages header in the response | always return Content-Type application/json in the header
        $response->headers->set('Content-Type', $contentType);

        // if request doesn't contain in header accept = application/json. Return a warning in the response
        if (strpos($acceptHeader, $contentType) === false) {
            $warnCode = '199'; // https://www.iana.org/assignments/http-warn-codes/http-warn-codes.xhtml
            $warnMessage = 'Missing request header [ accept = ' . $contentType . ' ] when calling a JSON API.';
            $response->headers->set('Warning', $warnCode . ' ' . $warnMessage);
        }

        // return the response
        return $response;
    }
}
