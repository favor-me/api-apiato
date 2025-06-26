@php
    /**
     * @var Illuminate\Database\Eloquent\Collection $roles
     */
@endphp

@extends('web.layouts.blank')

@push('scripts')
    <script src="{{ asset('js/pages/registration.js') }}"></script>
@endpush

@section('content')
    <div id="registration">
        <registration-component :roles="{{ $roles->values()->toJson() }}"/>
    </div>
@endsection
