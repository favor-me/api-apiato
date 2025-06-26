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

namespace App\Containers\AppSection\Authentication\UI\WEB\Controllers;

use Apiato\Core\Traits\ResponseTrait;
use App\Containers\AppSection\Authentication\Actions\WebLoginAction;
use App\Containers\AppSection\Authentication\Actions\WebLogoutAction;
use App\Containers\AppSection\Authentication\UI\WEB\Requests\LoginRequest;
use App\Containers\AppSection\Authentication\UI\WEB\Requests\LogoutRequest;
use App\Ship\Parents\Controllers\WebController;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Containers\AppSection\Authentication\Exceptions\UserNotConfirmedException;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class Controller extends WebController
{
    use ResponseTrait;

    /**
     * @param LoginRequest $request
     * @return RedirectResponse|JsonResponse
     * @throws LoginFailedException
     * @throws UserNotConfirmedException
     */
    public function login(LoginRequest $request): RedirectResponse|JsonResponse
    {
        return $request->isJson() ? $this->onJsonLogin($request) : $this->onLogin($request);
    }

    /**
     * @param LogoutRequest $request
     * @return RedirectResponse|Redirector
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function logout(LogoutRequest $request): RedirectResponse|Redirector
    {
        app(WebLogoutAction::class)->run();
        return redirect()->route('home');
    }

    public function showLoginPage(): Application|Factory|View
    {
        $pageTitle = __('appSection@authentication::authentication.page_title');
        return view('appSection@authentication::login', compact('pageTitle'));
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws LoginFailedException
     * @throws UserNotConfirmedException
     */
    protected function onJsonLogin(LoginRequest $request): JsonResponse
    {
        app(WebLoginAction::class)->run($request);
        return $this->json(['message' => 'OK']);
    }

    protected function onLogin(LoginRequest $request): RedirectResponse
    {
        $homeRoute = route('home');

        try {
            $result = app(WebLoginAction::class)->run($request);
        } catch (Exception $e) {
            return redirect()
                ->route(config('appSection-authentication.login-page-url'))
                ->with('_old_input.email', $request->get('email'))
                ->with('error', $e->getMessage());
        }

        return is_array($result)
            ? redirect()->route(config('appSection-authentication.login-page-url'))
            : redirect($homeRoute);
    }
}
