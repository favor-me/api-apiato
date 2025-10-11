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
 *
 * @apiGroup           OAuth2
 * @apiName            LoginPasswordGrant
 * @api                {post} /v1/oauth/token Login (Password Grant)
 * @apiDescription     Login Users using their username and passwords. (For First-Party Clients)
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiBody             {String}  username user email
 * @apiBody             {String}  password user password
 * @apiBody             {String}  client_id
 * @apiBody             {String}  client_secret
 * @apiBody             {String}  grant_type must be `password`
 * @apiBody             {String}  [scope] you can leave it empty
 *
 * @apiSuccessExample  {json}       Success-Response:
HTTP/1.1 200 OK
{
    "token_type": "Bearer",
    "expires_in": 315360000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbG...",
    "refresh_token": "Oukd61zgKzt8TBwRjnasd..."
}
 */

// Implementation in the Laravel Passport package
