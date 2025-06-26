@extends('web.layouts.blank')

@push('scripts')
    <script src="{{ asset('js/pages/forgot-password.js') }}"></script>
@endpush

@section('content')
    <div id="forgot-password">
        <forgot-password-component
            page-title="{{ $pageTitle }}"
            reset-url="{{ route('password.show-reset-form', [], false) }}"
            description="{{ __('appSection@user::page.forgot_password.description') }}"
        />
    </div>
@endsection
