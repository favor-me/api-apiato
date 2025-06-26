@extends('web.layouts.blank')

@section('content')
    Please see <a href="{{ route('public_docs') }}">Public API</a> or
    <a href="{{ route('private_docs') }}">Private API</a>
@endsection
