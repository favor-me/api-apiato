<?php

/**
 * @var string $resetUrl
 * @var string $email
 * @var string $token
 */

use Illuminate\Support\Arr;

$resetUrlQuery = Arr::query([
    'email' => $email,
    'token' => $token
]);

$uri = config('app.web_url') . $resetUrl . '?' . $resetUrlQuery;
?>
<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
    <head>
        <meta charset="utf-8"/>
    </head>
    <body>
        <h3>{{ __('appSection@user::mail.tpl_forgot_password.title') }}</h3>
        <div>
            {{ __('appSection@user::mail.tpl_forgot_password.token_label', ['token' => $token]) }}
        </div>
        <div>
            {{ __('appSection@user::mail.tpl_forgot_password.link_label') }}
            <a href="{{$uri}}">
                {{$uri}}
            </a>.
        </div>
    </body>
</html>
