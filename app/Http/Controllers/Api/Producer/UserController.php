<?php

namespace App\Http\Controllers\Api\Producer;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateBibliographyUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Requests\UpdateBibliographyRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {
    }


    public function registerUser(StoreUpdateUserRequest $request)
    {
        $user = $this->userService->create(
            CreateUserDTO::makeFromRequest($request)
        );

        return response()->json([
            'token' => $user->token,
            'user' => $user->user
        ], 201);
    }

    public function updateBibliographyUser(UpdateBibliographyRequest $request, string $id)
    {
        $bibliography = $this->userService->updateBibliographyUser(
            UpdateBibliographyUserDTO::makeFromRequest($request, $id)
        );

        if (!$bibliography) {
            return response()->json([
                'error' => 'User not found or bibliography could not be updated.'
            ], Response::HTTP_NOT_FOUND);
        }

        return new UserResource($bibliography);
    }

    public function updateUser(StoreUpdateUserRequest $request, string $id)
    {
        $user = $this->userService->update(
            UpdateUserDTO::makeFromRequest($request, $id)
        );

        if (!$user) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new UserResource($user);
    }
}
