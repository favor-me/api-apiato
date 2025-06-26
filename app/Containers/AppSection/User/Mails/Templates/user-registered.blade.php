@php
/**
 * @var string $name
 */
@endphp
<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
    <head>
        <meta charset="utf-8"/>
    </head>
    <body>
        <h3>{{ __('appSection@user::mail.tpl_registered.title', ['name' => $name]) }}</h3>
        <div>
            {{ __('appSection@user::mail.tpl_registered.message') }}
        </div>
    </body>
</html>
