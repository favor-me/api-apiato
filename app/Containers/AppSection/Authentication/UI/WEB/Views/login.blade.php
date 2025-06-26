@extends('web.layouts.blank')

@section('content')
    <div uk-height-viewport="expand:true" class="uk-container uk-container-small uk-height-viewport uk-overflow-hidden">
        <div class="uk-margin-xlarge-top uk-margin-medium-bottom uk-container-small uk-align-center uk-text-center">
            <h1>Все мастера в одном месте.</h1>
            <p>
                Тут нужен какой то текст передающий суть нашего на несколько строчек что бы смотрелся хорошо он тут. Алёна ты готова написать?
            </p>
        </div>
        <div class="uk-width-large uk-margin-auto">
            <div class="uk-card uk-card-default uk-card-body uk-margin-medium-top">
                <div class="uk-margin uk-h1 uk-text-center">

                </div>
                @include('appSection@authentication::includes.login-form')
            </div>
            <p class="uk-text-center">
                {{ __('appSection@welcome::welcome.no_account') }}
                <a href="{{ route('registration.show') }}">{{ __('core.register') }}.</a>
            </p>
        </div>
    </div>
@endsection
