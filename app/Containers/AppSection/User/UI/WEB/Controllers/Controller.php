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
 */

namespace App\Containers\AppSection\User\UI\WEB\Controllers;

use App\Containers\AppSection\Authorization\Actions\GetAllRolesAction;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Actions\RegisterUserAction;
use App\Containers\AppSection\User\UI\WEB\Requests\RegistrationRequest;
use App\Containers\AppSection\User\UI\WEB\Requests\ResetPasswordRequest;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;
use Illuminate\Support\Facades\Auth;

class Controller extends WebController
{
    public function registration(RegistrationRequest $request): RedirectResponse
    {
        try {
            $result = app(RegisterUserAction::class)->run($request->getDto());
            Auth::login($result, true);
            return redirect()
                ->route('profile.dashboard')
                ->with('success', __('appSection@user::user.registration_success_message', [
                    'name' => $result->getFullName()
                ]));
        } catch (Exception $e) {
            return redirect()
                ->route('registration.show')
                ->with('error', $e->getMessage());
        }
    }

    public function showForgotPasswordForm(): View
    {
        return view('appSection@user::forgot-password', [
            'pageTitle' => __('appSection@user::page.forgot_password.page_title')
        ]);
    }

    public function showProfile(): View
    {
        return view('appSection@user::profile', [
            'pageTitle' => __('appSection@user::page.profile.page_title')
        ]);
    }

    public function showRegistrationForm(): View
    {
        $pageTitle = __('appSection@authentication::authentication.page_title');

        $roles = app(GetAllRolesAction::class)->run()->filter(function (Role $role) {
            return in_array($role->name, config('appSection-user.registration.allowed-roles'));
        });

        return view('appSection@user::registration', compact('pageTitle', 'roles'));
    }

    public function showResetPasswordForm(ResetPasswordRequest $request): View
    {
        return view('appSection@user::reset-password', [
            'pageTitle' => __('appSection@user::page.reset_password.page_title'),
            'email' => $request->get('email'),
            'token' => $request->get('token')
        ]);
    }
}
