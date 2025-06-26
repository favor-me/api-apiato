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

namespace App\Containers\AppSection\Authentication\Tasks;

use GuzzleHttp\Utils;
use Illuminate\Http\Request;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\App;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;

/**
 * Class CallOAuthServerTask
 *
 * @package App\Containers\AppSection\Authentication\Tasks
 */
class CallOAuthServerTask extends Task
{
    /**
     * Run action.
     *
     * @param   array $data
     * @param   string|null $languageHeader
     *
     * @return  array
     *
     * @throws  LoginFailedException
     */
    public function run(array $data, string $languageHeader = null): array
    {
        $authFullApiUrl = route('passport.token');

        $headers = [
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_ACCEPT_LANGUAGE' => $languageHeader ?? config('app.locale'),
        ];

        $request  = Request::create($authFullApiUrl, 'POST', $data, [], [], $headers);
        $response = App::handle($request);
        $content  = Utils::jsonDecode($response->getContent(), true);

        // If the internal request to the oauth token endpoint was not successful we throw an exception
        if (!$response->isSuccessful()) {
            throw new LoginFailedException(null, $response->getStatusCode());
        }

        return $content;
    }
}
