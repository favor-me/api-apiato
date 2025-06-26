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
 * @var ViewErrorBag $errors
 */

use Illuminate\Support\ViewErrorBag;

?>

@extends('admin.login')

@php
    $emailInputClasses = ['form-control'];
    if (count((array) $errors->get('email'))) {
        array_push($emailInputClasses, 'is-invalid');
    }

    $passwordInputClasses = ['form-control'];
    if (count((array) $errors->get('password'))) {
        array_push($passwordInputClasses, 'is-invalid');
    }

    $emailPlaceHolder = __('appSection@authentication::authentication.placeholder.email');
    $passwordPlaceHolder = __('appSection@authentication::authentication.placeholder.password');
@endphp

@section('content')
    <div class="card-body">
        @include('admin.includes.flash')
        <form action="{{ route('login_post_form' )}}" method="post">
            <div>
                <div class="input-group mb-3">
                    <input type="email" name="email"
                           class="{{ implode(' ', $emailInputClasses) }}"
                           placeholder="{{ $emailPlaceHolder }}"/>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div>
                <div class="input-group mb-3">
                    <input type="password" name="password"
                           class="{{ implode(' ', $passwordInputClasses) }}"
                           placeholder="{{ $passwordPlaceHolder }}"/>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            {{ __('appSection@authentication::authentication.remember_me') }}
                        </label>
                    </div>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('appSection@authentication::authentication.sing_in') }}
                    </button>
                </div>
            </div>
            @csrf
        </form>
    </div>
@endsection
