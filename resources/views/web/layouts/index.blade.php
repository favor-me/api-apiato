<?php
   use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    @include('web.layouts.partials.head')
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
</head>
<body>
@include('web.layouts.partials.index.sidebar-mobile')
<aside class="tm-sidebar-left uk-visible@m">
    <div class="tm-sidebar-left-logo uk-padding-small">
        <x-logo/>
    </div>
    @include('web.layouts.partials.index.sidebar-left-profile')
    @include('web.layouts.partials.index.sidebar-left-navbar')
</aside>
<div class="tm-content" data-uk-height-viewport="expand: true">
    @yield('content')
</div>
<div class="tm-footer uk-margin-top">
    <x-site.footer/>
</div>
<script>
    @if (!is_null(Auth::getUser()))
        @php
        $userData = array_merge((new UserTransformer())->transform(Auth::getUser()), [
            'password' => Auth::getUser()->password
        ]);
        @endphp
        window.user = {!! json_encode($userData) !!}
    @endif
</script>
<script src="{{ asset('js/uikit.min.js') }}"></script>
@stack('scripts')
</body>
</html>
