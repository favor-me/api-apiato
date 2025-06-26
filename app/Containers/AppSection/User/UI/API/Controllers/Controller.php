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

namespace App\Containers\AppSection\User\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\User\Actions\CreateAdminAction;
use App\Containers\AppSection\User\Actions\DeleteUserAction;
use App\Containers\AppSection\User\Actions\DeleteUserProfileAction;
use App\Containers\AppSection\User\Actions\FindUserByIdAction;
use App\Containers\AppSection\User\Actions\ForgotPasswordAction;
use App\Containers\AppSection\User\Actions\GetAllAdminsAction;
use App\Containers\AppSection\User\Actions\GetAllClientsAction;
use App\Containers\AppSection\User\Actions\GetAllUsersAction;
use App\Containers\AppSection\User\Actions\GetAuthenticatedUserAction;
use App\Containers\AppSection\User\Actions\RegisterUserAction;
use App\Containers\AppSection\User\Actions\ResetPasswordAction;
use App\Containers\AppSection\User\Actions\UpdateUserAction;
use App\Containers\AppSection\User\Dto\ForgotUserPasswordDto;
use App\Containers\AppSection\User\Dto\RegisterUserDto;
use App\Containers\AppSection\User\Dto\ResetUserPasswordDto;
use App\Containers\AppSection\User\Dto\UpdateUserDto;
use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\UI\API\Requests\CreateAdminRequest;
use App\Containers\AppSection\User\UI\API\Requests\DeleteUserProfileRequest;
use App\Containers\AppSection\User\UI\API\Requests\DeleteUserRequest;
use App\Containers\AppSection\User\UI\API\Requests\FindUserByIdRequest;
use App\Containers\AppSection\User\UI\API\Requests\ForgotPasswordRequest;
use App\Containers\AppSection\User\UI\API\Requests\GetAllUsersRequest;
use App\Containers\AppSection\User\UI\API\Requests\GetAuthenticatedUserRequest;
use App\Containers\AppSection\User\UI\API\Requests\RegisterUserRequest;
use App\Containers\AppSection\User\UI\API\Requests\ResetPasswordRequest;
use App\Containers\AppSection\User\UI\API\Requests\UpdateUserRequest;
use App\Containers\AppSection\User\UI\API\Transformers\UserPrivateProfileTransformer;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class Controller extends ApiController
{
    /**
     * @param CreateAdminRequest $request
     * @return array
     * @throws CreateResourceFailedException
     * @throws InvalidTransformerException
     * @throws UnknownProperties
     */
    public function createAdmin(CreateAdminRequest $request): array
    {
        $dto = new RegisterUserDto($request->all());
        $admin = app(CreateAdminAction::class)->run($dto);
        return $this->transform($admin, UserTransformer::class);
    }

    /**
     * @param DeleteUserRequest $request
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function deleteUser(DeleteUserRequest $request): JsonResponse
    {
        app(DeleteUserAction::class)->run((array)$request->ids);
        return $this->noContent();
    }

    /**
     * @param DeleteUserProfileRequest $request
     * @return JsonResponse
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function deleteUserProfile(DeleteUserProfileRequest $request): JsonResponse
    {
        app(DeleteUserProfileAction::class)->run();

        return $this->json([
            MESSAGE => Container::trans('user.profile_deleted')
        ]);
    }

    /**
     * @param FindUserByIdRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws NotFoundException
     */
    public function findUserById(FindUserByIdRequest $request): array
    {
        $user = app(FindUserByIdAction::class)->run((int)$request->id);
        return $this->transform($user, UserTransformer::class);
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     * @throws InternalErrorException
     * @throws NotFoundException
     * @throws UnknownProperties
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $dto = new ForgotUserPasswordDto($request->all());
        app(ForgotPasswordAction::class)->run($dto);
        return $this->noContent(202);
    }

    /**
     * @param GetAllUsersRequest $request
     * @return array
     * @throws CoreInternalErrorException
     * @throws InvalidTransformerException
     * @throws RepositoryException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getAllAdmins(GetAllUsersRequest $request): array
    {
        $users = app(GetAllAdminsAction::class)->run();
        return $this->transform($users, UserTransformer::class);
    }

    /**
     * @param GetAllUsersRequest $request
     * @return array
     * @throws CoreInternalErrorException
     * @throws InvalidTransformerException
     * @throws RepositoryException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getAllClients(GetAllUsersRequest $request): array
    {
        $users = app(GetAllClientsAction::class)->run();
        return $this->transform($users, UserTransformer::class);
    }

    /**
     * @param GetAllUsersRequest $request
     * @return array
     * @throws CoreInternalErrorException
     * @throws InvalidTransformerException
     * @throws RepositoryException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getAllUsers(GetAllUsersRequest $request): array
    {
        $users = app(GetAllUsersAction::class)->run();
        return $this->transform($users, UserTransformer::class);
    }

    /**
     * @param GetAuthenticatedUserRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws NotFoundException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getAuthenticatedUser(GetAuthenticatedUserRequest $request): array
    {
        $user = app(GetAuthenticatedUserAction::class)->run();
        return $this->transform($user, UserPrivateProfileTransformer::class);
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     * @throws InternalErrorException
     * @throws UnknownProperties
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $dto = new ResetUserPasswordDto($request->all());
        $resetPasswordStatus = app(ResetPasswordAction::class)->run($dto);

        $responseStatus = $resetPasswordStatus === Password::PASSWORD_RESET ?
            Response::HTTP_OK : Response::HTTP_EXPECTATION_FAILED;

        return $this->json([
            'message' => __($resetPasswordStatus)
        ], $responseStatus);
    }

    /**
     * @param UpdateUserRequest $request
     * @return array
     * @throws InternalErrorException
     * @throws InvalidTransformerException
     * @throws NotFoundException
     * @throws UnknownProperties
     */
    public function updateUser(UpdateUserRequest $request): array
    {
        $dto = new UpdateUserDto($request->all());
        $user = app(UpdateUserAction::class)->run($dto);
        return $this->transform($user, UserTransformer::class);
    }
}
