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

namespace App\Ship\Exceptions\Handlers;

use Throwable;
use App\Ship\Parents\Exceptions\Exception as ParentException;
use Apiato\Core\Exceptions\Handlers\ExceptionsHandler as CoreExceptionsHandler;

/**
 * Class ExceptionsHandler
 *
 * @package App\Ship\Exceptions\Handlers
 */
class ExceptionsHandler extends CoreExceptionsHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });

        $this->renderable(function (ParentException $e) {
            $response = null;

            if (config('app.debug')) {
                $response = [
                    'message' => $e->getMessage(),
                    'errors' => (object) $e->getErrors(),
                    'exception' => static::class,
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->gettrace()
                ];
            } else {
                $response = [
                    'message' => $e->getMessage(),
                    'errors' => (object) $e->getErrors()
                ];
            }

            return response()->json($response, $e->getCode());
        });
    }
}
