@extends('web.layouts.index')

@push('scripts')
    <script src="{{ asset('js/pages/profile-show.js') }}"></script>
@endpush

@section('content')
    <div id="profile-show" class="uk-container uk-container-large">
        <profile-show-component user-id="{{ auth()->user()->getHashedKey() }}"/>
    </div>
@endsection
