@extends('web.layouts.blank')

@push('scripts')
    <script src="{{ asset('js/pages/reset-password.js') }}"></script>
@endpush

@section('content')
    <div id="reset-password">
        <reset-password-component
            email="{{ $email }}"
            token="{{ $token }}"
            go-back-url="{{ route('password.show-forgot-form') }}"
        />
    </div>
@endsection
